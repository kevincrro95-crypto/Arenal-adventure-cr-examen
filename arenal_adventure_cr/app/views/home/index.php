<section class="hero">
  <div class="container hero-content">
    <span class="tag">Turismo nacional desde La Fortuna</span>
    <h1>Descubra Costa Rica a su manera</h1>
    <p>Organice hospedaje, actividades y transporte privado para conocer volcanes, cataratas, bosques y playas.</p>
    <div class="hero-actions"><a class="btn" href="index.php?route=destinations">Explorar destinos</a><a class="btn outline" href="index.php?route=activities">Ver tours</a></div>
    <?php if($rate):?><span class="rate">Tipo de cambio: USD 1 ≈ ₡<?=number_format($rate,2)?></span><?php endif;?>
  </div>
</section>
<section class="container section">
  <div class="section-title"><div><span class="eyebrow">Lugares recomendados</span><h2>Destinos destacados</h2></div><a href="index.php?route=destinations">Ver todos</a></div>
  <div class="grid"><?php foreach(array_slice($destinations,0,3) as $d):?><article class="card"><img loading="lazy" src="<?=Security::e($d['image'])?>" alt="<?=Security::e($d['name'])?>"><div class="card-body"><small><?=Security::e($d['province'])?></small><h3><?=Security::e($d['name'])?></h3><p><?=Security::e(mb_strimwidth($d['description'],0,120,'...'))?></p><a href="index.php?route=destination&id=<?=$d['id']?>">Ver información →</a></div></article><?php endforeach;?></div>
</section>
<section class="soft-section"><div class="container section">
  <div class="section-title"><div><span class="eyebrow">Hospedaje en la zona</span><h2>Hoteles recomendados</h2></div><a href="index.php?route=hotels">Ver hoteles</a></div>
  <div class="grid"><?php foreach($hotels as $h):?><article class="card"><img loading="lazy" src="<?=Security::e($h['image'])?>" alt="<?=Security::e($h['name'])?>"><div class="card-body"><small><?=str_repeat('★',(int)$h['category'])?> · <?=Security::e($h['destination_name']??'Costa Rica')?></small><h3><?=Security::e($h['name'])?></h3><p><?=Security::e(mb_strimwidth($h['description'],0,105,'...'))?></p><strong>Desde ₡<?=number_format((float)$h['price_per_night'],0)?> por noche</strong></div></article><?php endforeach;?></div>
</div></section>
<section class="container section">
  <div class="section-title"><div><span class="eyebrow">Naturaleza y aventura</span><h2>Experiencias para su viaje</h2></div><a href="index.php?route=activities">Ver actividades</a></div>
  <div class="grid"><?php foreach($activities as $a):?><article class="card"><img loading="lazy" src="<?=Security::e($a['image'])?>" alt="<?=Security::e($a['name'])?>"><div class="card-body"><small><?=Security::e($a['type'])?> · <?=Security::e($a['duration'])?></small><h3><?=Security::e($a['name'])?></h3><p><?=Security::e(mb_strimwidth($a['description'],0,105,'...'))?></p><strong>₡<?=number_format((float)$a['price'],0)?> por persona</strong></div></article><?php endforeach;?></div>
</section>
<section class="band"><div class="container"><span class="eyebrow light">Servicio para grupos pequeños</span><h2>Viaje cómodo y sin complicaciones</h2><div class="features"><div>🚗<strong>Transporte privado</strong><p>Dos automóviles y un SUV para traslados y recorridos personalizados.</p></div><div>🏨<strong>Hospedajes</strong><p>Opciones de la zona para distintos presupuestos y estilos de viaje.</p></div><div>🧭<strong>Experiencias</strong><p>Canopy, senderismo, aguas termales, rafting y recorridos naturales.</p></div></div></div></section>
<section class="container section about-grid"><div><span class="eyebrow">Arenal Adventure CR</span><h2>Una plataforma turística y académica que sí funciona</h2><p>El sistema permite consultar destinos, hoteles y actividades, crear una cuenta, reservar y revisar el historial. El administrador puede mantener la información y consultar reportes.</p><a class="btn" href="index.php?route=register">Crear una cuenta</a></div><div class="fact-box"><strong>2 automóviles</strong><span>Para traslados privados</span><strong>1 SUV</strong><span>Para rutas y grupos pequeños</span><strong>Atención personalizada</strong><span>Itinerarios según cada visitante</span></div></section>
