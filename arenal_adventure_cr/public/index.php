<?php
session_start();
ini_set('display_errors','0');
error_reporting(E_ALL);
spl_autoload_register(function($class){foreach(['/../app/core/','/../app/models/','/../app/controllers/','/../app/services/'] as $dir){$file=__DIR__.$dir.$class.'.php';if(file_exists($file)){require_once $file;return;}}});
$route=trim($_GET['route']??'home','/');
try{
 switch($route){
  case 'home':(new HomeController())->index();break;
  case 'destination':(new HomeController())->destination();break;
  case 'destinations':(new CatalogController())->destinations();break;
  case 'hotels':(new CatalogController())->hotels();break;
  case 'activities':(new CatalogController())->activities();break;
  case 'login':(new AuthController())->login();break;
  case 'authenticate':(new AuthController())->authenticate();break;
  case 'register':(new AuthController())->register();break;
  case 'register/store':(new AuthController())->store();break;
  case 'forgot':(new AuthController())->forgot();break;
  case 'forgot/send':(new AuthController())->resetSimulation();break;
  case 'logout':(new AuthController())->logout();break;
  case 'reservation/create':(new ReservationController())->create();break;
  case 'reservation/store':(new ReservationController())->store();break;
  case 'reservations':(new ReservationController())->index();break;
  case 'profile':(new ProfileController())->index();break;
  case 'profile/update':(new ProfileController())->update();break;
  case 'profile/password':(new ProfileController())->password();break;
  case 'admin':(new AdminController())->index();break;
  case 'admin/users':(new AdminController())->users();break;
  case 'admin/user/save':(new AdminController())->saveUser();break;
  case 'admin/user/delete':(new AdminController())->deleteUser();break;
  case 'admin/reservations':(new AdminController())->reservations();break;
  case 'admin/reservation/status':(new AdminController())->reservationStatus();break;
  case 'admin/reservation/delete':(new AdminController())->reservationDelete();break;
  case 'admin/reports':(new AdminController())->reports();break;
  case 'admin/destinations':(new AdminController())->crud('destination');break;
  case 'admin/hotels':(new AdminController())->crud('hotel');break;
  case 'admin/activities':(new AdminController())->crud('activity');break;
  case 'admin/destination/save':(new AdminController())->save('destination');break;
  case 'admin/hotel/save':(new AdminController())->save('hotel');break;
  case 'admin/activity/save':(new AdminController())->save('activity');break;
  case 'admin/destination/delete':(new AdminController())->delete('destination');break;
  case 'admin/hotel/delete':(new AdminController())->delete('hotel');break;
  case 'admin/activity/delete':(new AdminController())->delete('activity');break;
  default:http_response_code(404);echo '<h1>Página no encontrada</h1>';
 }
}catch(Throwable $e){Logger::error($e);http_response_code(500);echo '<h2>Ocurrió un error inesperado.</h2><p>Por favor vuelva a intentarlo.</p>';}
