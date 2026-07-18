<?php
class ProfileController extends Controller {
 public function index():void{Auth::requireLogin();$user=(new User())->find(Auth::user()['id']);$this->view('profile/index',compact('user'));}
 public function update():void{
  Auth::requireLogin();Security::validateCsrf();$model=new User();$current=$model->find(Auth::user()['id']);
  $d=['name'=>Security::post('name'),'email'=>Security::post('email'),'phone'=>Security::post('phone'),'photo'=>$current['photo']??null];
  if(strlen($d['name'])<3||strlen($d['name'])>100||!filter_var($d['email'],FILTER_VALIDATE_EMAIL)){$_SESSION['error']='Nombre o correo inválido.';$this->redirect('profile');}
  if($model->emailExists($d['email'],Auth::user()['id'])){$_SESSION['error']='Ese correo ya está registrado.';$this->redirect('profile');}
  if(!empty($_FILES['photo']['name'])){$d['photo']=$this->savePhoto($_FILES['photo']);}
  $model->updateProfile(Auth::user()['id'],$d);$_SESSION['user']['name']=$d['name'];$_SESSION['user']['email']=$d['email'];$_SESSION['success']='Perfil actualizado.';$this->redirect('profile');
 }
 public function password():void{Auth::requireLogin();Security::validateCsrf();$p=Security::post('password');$confirm=Security::post('password_confirm');if(strlen($p)<6){$_SESSION['error']='La contraseña debe tener al menos 6 caracteres.';}elseif($p!==$confirm){$_SESSION['error']='Las contraseñas no coinciden.';}else{(new User())->changePassword(Auth::user()['id'],$p);$_SESSION['success']='Contraseña actualizada.';}$this->redirect('profile');}
 private function savePhoto(array $file):string{
  if(($file['error']??UPLOAD_ERR_NO_FILE)!==UPLOAD_ERR_OK)throw new Exception('No se pudo subir la fotografía.');
  if(($file['size']??0)>2*1024*1024)throw new Exception('La fotografía no puede superar 2 MB.');
  $mime=(new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);$types=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];if(!isset($types[$mime]))throw new Exception('Solo se permiten imágenes JPG, PNG o WEBP.');
  $name='profile_'.Auth::user()['id'].'_'.bin2hex(random_bytes(4)).'.'.$types[$mime];$folder=__DIR__.'/../../public/uploads/';if(!is_dir($folder))mkdir($folder,0775,true);if(!move_uploaded_file($file['tmp_name'],$folder.$name))throw new Exception('No se pudo guardar la fotografía.');return 'uploads/'.$name;
 }
}
