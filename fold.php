<?php
require_once "conn.php";

extract($_POST);
$sql = "UPDATE `game_logs` SET `lost_money`='$money', `over_type` = 'Fold' WHERE  game_id = '$gameId'";
$conn->exec($sql);