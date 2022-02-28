<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "poker";
$id = 2;

try {
  $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare("SELECT id, wallet FROM users WHERE id = '$id'");
  $stmt->execute();
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $user = $stmt->fetch();
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  die;
}