<?php

$connection = [
  'host' => 'localhost',
  'user'=> 'root',
  'database' => 'test'
];

$mysqli = new mysqli(
  $connection['host'],
  $connection['user'],
  '',
  $connection['database']);

if($mysqli->connect_error){
  die('Error connecting to database  ' . $mysqli->connect_error);
}
