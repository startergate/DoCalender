<?php
  require '../config/config.php';
  header('Content-Type: application/json');
  $conn = new mysqli($config['host'], $config['duser'], $config['dpw'], $config['dname']);  //Note Database
  if (!empty($_POST['note'])) {
      $pid = $_POST['pid'];
      $date = $_POST['date'];
      $note = $_POST['note'];
      $udb = 'userdb_'.$pid;
      $sql = "INSERT INTO $udb (date, note) VALUES ('$date','$note')";
      $result = $conn->query($sql);
      echo urldecode(json_encode(['status'=>1]));
      exit;
  } else {
      echo urldecode(json_encode(['status'=>0]));
  }
