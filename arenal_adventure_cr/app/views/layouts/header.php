<?php $config=require __DIR__.'/../../config/config.php';$base=$config['base_url']; ?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="Destinos, hoteles, tours y transporte privado en Costa Rica.">
<title><?= Security::e($config['app_name']) ?></title>
<link rel="icon" href="<?= $base ?>/assets/images/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="<?= $base ?>/assets/css/style.css">
</head>
<body>
<header>
<nav class="nav container">
<a class="brand" href="index.php?route=home"><img src="<?= $base ?>/assets/images/logo-arenal.svg" alt="Arenal Adventure CR"></a>
<button class="menu" type="button" aria-label="Abrir menú" onclick="document.querySelector('.links').classList.toggle('show')">☰</button>
<div class="links">
<a href="index.php?route=destinations">Destinos</a><a href="index.php?route=hotels">Hoteles</a><a href="index.php?route=activities">Actividades</a>
<?php if(Auth::check()): ?><a href="index.php?route=reservation/create">Reservar</a><a href="index.php?route=reservations">Mis reservas</a><a href="index.php?route=profile">Perfil</a><?php if(Auth::isAdmin()): ?><a href="index.php?route=admin">Administración</a><?php endif; ?><a href="index.php?route=logout">Salir</a><?php else: ?><a href="index.php?route=login">Ingresar</a><a class="btn small" href="index.php?route=register">Registrarse</a><?php endif; ?>
</div></nav></header>
<main><?php if(!empty($_SESSION['success'])):?><div class="alert success container"><?=Security::e($_SESSION['success']);unset($_SESSION['success']);?></div><?php endif;?><?php if(!empty($_SESSION['error'])):?><div class="alert error container"><?=Security::e($_SESSION['error']);unset($_SESSION['error']);?></div><?php endif;?>
