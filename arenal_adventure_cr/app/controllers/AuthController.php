<?php
class AuthController extends Controller {
 public function login():void{$this->view('auth/login');}
 public function authenticate():void{Security::validateCsrf();$email=filter_var(Security::post('email'),FILTER_VALIDATE_EMAIL);$password=Security::post('password');$user=$email?(new User())->findByEmail($email):null;if($user&&password_verify($password,$user['password'])){session_regenerate_id(true);unset($user['password']);$_SESSION['user']=$user;$_SESSION['success']='Bienvenido, '.$user['name'];$this->redirect($user['role']==='admin'?'admin':'home');}$_SESSION['error']='Correo o contraseña incorrectos.';$this->redirect('login');}
 public function register():void{$this->view('auth/register');}
 public function store():void{Security::validateCsrf();$d=['name'=>Security::post('name'),'email'=>Security::post('email'),'phone'=>Security::post('phone'),'password'=>Security::post('password')];if(strlen($d['name'])<3||!filter_var($d['email'],FILTER_VALIDATE_EMAIL)||strlen($d['password'])<6){$_SESSION['error']='Revise los datos. La contraseña debe tener al menos 6 caracteres.';$this->redirect('register');}try{(new User())->create($d);$_SESSION['success']='Cuenta creada. Ya puede iniciar sesión.';$this->redirect('login');}catch(Throwable $e){Logger::error($e);$_SESSION['error']='No se pudo registrar. Puede que el correo ya exista.';$this->redirect('register');}}
 public function logout():void{$_SESSION=[];session_destroy();session_start();$_SESSION['success']='Sesión cerrada correctamente.';$this->redirect('home');}
 public function forgot():void{$this->view('auth/forgot');}
 public function resetSimulation():void{Security::validateCsrf();$_SESSION['success']='Simulación completada: se enviaría un enlace temporal al correo indicado.';$this->redirect('login');}
}
