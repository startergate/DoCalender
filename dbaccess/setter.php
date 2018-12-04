<?php
  require("../config/config.php");
  require("../lib/codegen.php");
  header('Content-Type: application/json');
  $conn = new mysqli($config["host"], $config["duser"], $config["dpw"], $config["dname"]);  //Note Database
  if (!empty($_POST['text'])) {
      $pid = $_POST['pid'];
      $date = $_POST['date'];
      $note = $_POST['note'];
      $udb = 'userdb_'.$pid;
      $sql = "INSERT INTO $udb (date, note) VALUES ('$date','$note')";
      $result = $conn -> query($sql);
      echo urldecode(json_encode(array("pid"=>$rand)));
      exit;
  } else {
      echo urldecode(json_encode(array("error"=>1)));
  }
