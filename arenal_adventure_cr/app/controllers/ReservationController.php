<?php
class ReservationController extends Controller {
 public function create():void{Auth::requireLogin();$hotels=(new Hotel())->active();$activities=(new Activity())->active();$this->view('reservations/create',compact('hotels','activities'));}
 public function store():void{
  Auth::requireLogin();Security::validateCsrf();$hotelId=(int)Security::post('hotel_id');$checkIn=Security::post('check_in');$checkOut=Security::post('check_out');$people=(int)Security::post('people');$activities=array_values(array_unique(array_map('intval',$_POST['activities']??[])));
  if(!$this->validDate($checkIn)||!$this->validDate($checkOut)||$checkIn<date('Y-m-d')||$checkOut<=$checkIn||$people<1||$people>50){$_SESSION['error']='Revise las fechas y la cantidad de personas.';$this->redirect('reservation/create');}
  $hotel=(new Hotel())->find($hotelId);if(!$hotel||(int)$hotel['status']!==1){$_SESSION['error']='El hotel seleccionado no está disponible.';$this->redirect('reservation/create');}
  $reservationModel=new Reservation();if(!$reservationModel->hotelAvailable($hotelId,$checkIn,$checkOut)){$_SESSION['error']='No hay habitaciones disponibles para esas fechas.';$this->redirect('reservation/create');}
  $days=max(1,(new DateTime($checkIn))->diff(new DateTime($checkOut))->days);$total=$days*(float)$hotel['price_per_night'];$am=new Activity();
  foreach($activities as $id){$a=$am->find($id);if(!$a||(int)$a['status']!==1||(int)$a['destination_id']!==(int)$hotel['destination_id']){$_SESSION['error']='Las actividades deben estar activas y pertenecer al mismo destino del hotel.';$this->redirect('reservation/create');}if(!$reservationModel->activityAvailable($id,$people,$checkIn,$checkOut)){$_SESSION['error']='Una de las actividades ya no tiene cupo suficiente.';$this->redirect('reservation/create');}$total+=(float)$a['price']*$people;}
  $reservationModel->create(['user_id'=>Auth::user()['id'],'hotel_id'=>$hotelId,'check_in'=>$checkIn,'check_out'=>$checkOut,'people'=>$people,'total'=>$total,'notes'=>mb_substr(Security::post('notes'),0,500)],$activities);$_SESSION['success']='Reservación registrada. Queda pendiente de confirmación.';$this->redirect('reservations');
 }
 public function index():void{Auth::requireLogin();$items=(new Reservation())->byUser(Auth::user()['id']);$this->view('reservations/index',['reservations'=>$items]);}
 private function validDate(string $date):bool{$d=DateTime::createFromFormat('Y-m-d',$date);return $d&&$d->format('Y-m-d')===$date;}
}
