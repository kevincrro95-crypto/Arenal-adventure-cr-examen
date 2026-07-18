<?php
class HomeController extends Controller {
 public function index():void{ $destinations=(new Destination())->active();$hotels=array_slice((new Hotel())->active(),0,3);$activities=array_slice((new Activity())->active(),0,3);$rate=(new ApiService())->exchangeRate();$this->view('home/index',compact('destinations','hotels','activities','rate')); }
 public function destination():void{$id=(int)($_GET['id']??0);$destination=(new Destination())->find($id);if(!$destination){$this->redirect('home');}$hotels=(new Hotel())->all($id);$activities=(new Activity())->all($id);$weather=(new ApiService())->weather((float)$destination['latitude'],(float)$destination['longitude']);$this->view('destinations/detail',compact('destination','hotels','activities','weather'));}
}
