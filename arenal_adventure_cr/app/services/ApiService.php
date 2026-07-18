<?php
class ApiService {
 private function getJson(string $url):?array{
  $context=stream_context_create(['http'=>['timeout'=>4,'ignore_errors'=>true]]);
  $json=@file_get_contents($url,false,$context); return $json?json_decode($json,true):null;
 }
 public function weather(float $lat,float $lon):?array{
  $url='https://api.open-meteo.com/v1/forecast?latitude='.urlencode((string)$lat).'&longitude='.urlencode((string)$lon).'&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m&timezone=America%2FCosta_Rica';
  return $this->getJson($url)['current']??null;
 }
 public function exchangeRate():?float{
  $data=$this->getJson('https://api.frankfurter.dev/v1/latest?base=USD&symbols=CRC'); return isset($data['rates']['CRC'])?(float)$data['rates']['CRC']:null;
 }
}
