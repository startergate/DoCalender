<?php
  require '../config/config.php';
  header('Content-Type: application/json');
  $output = json_encode(['error'=>1]);
  $conn = new mysqli($config['host'], $config['duser'], $config['dpw'], $config['dname']);  //Note Database
  $sql = 'SELECT note FROM userdb_'.$_POST['pid']." WHERE date LIKE '".$_POST['date']."'";
  $result = $conn->query($sql);
  if ($row = $result->fetch_assoc()) {
      $output = json_encode($row);
  }
  echo urldecode($output);
