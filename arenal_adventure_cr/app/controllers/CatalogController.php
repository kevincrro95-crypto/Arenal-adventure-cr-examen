<?php
class CatalogController extends Controller {
 public function destinations():void{$search=trim($_GET['search']??'');$items=(new Destination())->all($search);$this->view('destinations/index',['destinations'=>$items,'search'=>$search]);}
 public function hotels():void{$destination=(int)($_GET['destination']??0);$items=(new Hotel())->all($destination);$destinations=(new Destination())->active();$this->view('hotels/index',['hotels'=>$items,'destinations'=>$destinations,'selected'=>$destination]);}
 public function activities():void{$destination=(int)($_GET['destination']??0);$items=(new Activity())->all($destination);$destinations=(new Destination())->active();$this->view('activities/index',['activities'=>$items,'destinations'=>$destinations,'selected'=>$destination]);}
}
