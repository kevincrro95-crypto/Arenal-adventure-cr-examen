<?php
class AdminController extends Controller {
 public function index():void{Auth::requireAdmin();$reports=(new Reservation())->reports();$this->view('admin/dashboard',compact('reports'));}

 public function users():void{
  Auth::requireAdmin();
  $model=new User();
  $users=$model->all();
  $edit=!empty($_GET['id'])?$model->find((int)$_GET['id']):null;
  $this->view('admin/users',compact('users','edit'));
 }

 public function saveUser():void{
  Auth::requireAdmin();Security::validateCsrf();
  $d=['id'=>(int)($_POST['id']??0),'name'=>Security::post('name'),'email'=>Security::post('email'),'phone'=>Security::post('phone'),'role'=>Security::post('role'),'status'=>(int)Security::post('status'),'password'=>Security::post('password')];
  $model=new User();
  if(strlen($d['name'])<3||strlen($d['name'])>100){$_SESSION['error']='El nombre debe tener entre 3 y 100 caracteres.';$this->redirect('admin/users');}
  if(!filter_var($d['email'],FILTER_VALIDATE_EMAIL)||strlen($d['email'])>150){$_SESSION['error']='El correo no es válido.';$this->redirect('admin/users');}
  if(!in_array($d['role'],['admin','client'],true)||!in_array($d['status'],[0,1],true)){$_SESSION['error']='Rol o estado inválido.';$this->redirect('admin/users');}
  if($d['id']===0&&strlen($d['password'])<6){$_SESSION['error']='La contraseña debe tener al menos 6 caracteres.';$this->redirect('admin/users');}
  if($d['password']!==''&&strlen($d['password'])<6){$_SESSION['error']='La contraseña debe tener al menos 6 caracteres.';$this->redirect('admin/users');}
  if($model->emailExists($d['email'],$d['id'])){$_SESSION['error']='Ese correo ya está registrado.';$this->redirect('admin/users');}
  if($d['id']===(int)Auth::user()['id']&&$d['status']===0){$_SESSION['error']='No puede desactivar su propio usuario.';$this->redirect('admin/users');}
  $model->adminSave($d);$_SESSION['success']='Usuario guardado correctamente.';$this->redirect('admin/users');
 }

 public function deleteUser():void{
  Auth::requireAdmin();Security::validateCsrf();$id=(int)($_POST['id']??0);
  if($id===(int)Auth::user()['id']){$_SESSION['error']='No puede eliminar su propio usuario.';$this->redirect('admin/users');}
  try{(new User())->delete($id);$_SESSION['success']='Usuario eliminado.';}catch(Throwable $e){Logger::error($e);$_SESSION['error']='No se puede eliminar porque el usuario tiene reservaciones. Puede desactivarlo.';}
  $this->redirect('admin/users');
 }

 public function reservations():void{Auth::requireAdmin();$this->view('admin/reservations',['reservations'=>(new Reservation())->all()]);}
 public function reservationStatus():void{Auth::requireAdmin();Security::validateCsrf();$id=(int)($_POST['id']??0);$status=Security::post('status');if(!in_array($status,['pending','confirmed','cancelled','completed'],true)){$_SESSION['error']='Estado inválido.';}else{(new Reservation())->updateStatus($id,$status);$_SESSION['success']='Estado de la reservación actualizado.';}$this->redirect('admin/reservations');}
 public function reservationDelete():void{Auth::requireAdmin();Security::validateCsrf();(new Reservation())->delete((int)($_POST['id']??0));$_SESSION['success']='Reservación eliminada.';$this->redirect('admin/reservations');}

 public function reports():void{
  Auth::requireAdmin();$from=trim($_GET['from']??'');$to=trim($_GET['to']??'');
  if(($from!==''&&!$this->validDate($from))||($to!==''&&!$this->validDate($to))||($from!==''&&$to!==''&&$from>$to)){$_SESSION['error']='El rango de fechas no es válido.';$this->redirect('admin/reports');}
  $reports=(new Reservation())->reports($from,$to);$this->view('admin/reports',compact('reports'));
 }

 public function crud(string $type):void{Auth::requireAdmin();$models=['destination'=>new Destination(),'hotel'=>new Hotel(),'activity'=>new Activity()];if(!isset($models[$type])){throw new Exception('Módulo inválido.');}$model=$models[$type];$items=$model->all();$destinations=(new Destination())->all();$edit=!empty($_GET['id'])?$model->find((int)$_GET['id']):null;$this->view('admin/crud',compact('type','items','destinations','edit'));}

 public function save(string $type):void{
  Auth::requireAdmin();Security::validateCsrf();$model=['destination'=>new Destination(),'hotel'=>new Hotel(),'activity'=>new Activity()][$type]??null;if(!$model){throw new Exception('Módulo inválido.');}
  $d=$_POST;foreach($d as $k=>$v){if(is_string($v))$d[$k]=trim($v);} $d['id']=(int)($d['id']??0);$d['status']=(int)($d['status']??1);
  $error=$this->validateCrud($type,$d);if($error!==''){$_SESSION['error']=$error;$this->redirect('admin/'.$type.'s'.($d['id']?'&id='.$d['id']:''));}
  $model->save($d);$_SESSION['success']='Registro guardado.';$this->redirect('admin/'.$type.'s');
 }

 public function delete(string $type):void{Auth::requireAdmin();Security::validateCsrf();try{(['destination'=>new Destination(),'hotel'=>new Hotel(),'activity'=>new Activity()][$type])->delete((int)($_POST['id']??0));$_SESSION['success']='Registro eliminado.';}catch(Throwable $e){Logger::error($e);$_SESSION['error']='No se puede eliminar porque el registro tiene información relacionada.';}$this->redirect('admin/'.$type.'s');}

 private function validDate(string $date):bool{$d=DateTime::createFromFormat('Y-m-d',$date);return $d&&$d->format('Y-m-d')===$date;}
 private function validateCrud(string $type,array &$d):string{
  if(!in_array($d['status'],[0,1],true))return 'El estado no es válido.';
  if($type==='destination'){
   if(strlen($d['name']??'')<3||strlen($d['name'])>120)return 'El nombre del destino debe tener entre 3 y 120 caracteres.';
   if(strlen($d['province']??'')<3||strlen($d['province'])>80)return 'La provincia no es válida.';
   if(strlen($d['description']??'')<20)return 'La descripción debe tener al menos 20 caracteres.';
   foreach(['latitude','longitude'] as $field){if(($d[$field]??'')!==''&&!is_numeric($d[$field]))return 'Las coordenadas deben ser numéricas.';}
   $d['latitude']=$d['latitude']===''?null:(float)$d['latitude'];$d['longitude']=$d['longitude']===''?null:(float)$d['longitude'];
   if($d['latitude']!==null&&($d['latitude']<-90||$d['latitude']>90))return 'La latitud no es válida.';
   if($d['longitude']!==null&&($d['longitude']<-180||$d['longitude']>180))return 'La longitud no es válida.';
  }elseif($type==='hotel'){
   $d['destination_id']=(int)($d['destination_id']??0);$d['category']=(int)($d['category']??0);$d['rooms']=(int)($d['rooms']??0);$d['price_per_night']=(float)($d['price_per_night']??-1);
   if(!(new Destination())->find($d['destination_id']))return 'Debe seleccionar un destino válido.';
   if(strlen($d['name']??'')<3||strlen($d['name'])>150)return 'El nombre del hotel no es válido.';
   if($d['category']<1||$d['category']>5)return 'La categoría debe estar entre 1 y 5.';
   if($d['price_per_night']<0||$d['rooms']<0)return 'El precio y las habitaciones no pueden ser negativos.';
   if(($d['email']??'')!==''&&!filter_var($d['email'],FILTER_VALIDATE_EMAIL))return 'El correo del hotel no es válido.';
  }else{
   $allowed=['Canopy','Rafting','Senderismo','Buceo','Tours','Cabalgatas','Otros'];
   $d['destination_id']=(int)($d['destination_id']??0);$d['price']=(float)($d['price']??-1);$d['max_capacity']=(int)($d['max_capacity']??0);
   if(!(new Destination())->find($d['destination_id']))return 'Debe seleccionar un destino válido.';
   if(strlen($d['name']??'')<3||strlen($d['name'])>150)return 'El nombre de la actividad no es válido.';
   if(!in_array($d['type']??'',$allowed,true))return 'El tipo de actividad no es válido.';
   if($d['price']<0||$d['max_capacity']<1)return 'El precio o el cupo no son válidos.';
  }
  if(isset($d['image'])&&$d['image']!==''&&!filter_var($d['image'],FILTER_VALIDATE_URL))return 'La imagen debe ser una URL válida.';
  return '';
 }
}
