<?php
require_once "conn.php";

extract($_POST);
$wallet = $user['wallet'] - $money;
$sql = "START TRANSACTION;";
$sql .= "INSERT INTO `game_logs`(`game_id`, `u_id`, `deal_money`, `game_win`, `win_money`, `lost_money`) 
        VALUES ('$gameId','$memberId','$money','0','0','0');";
$sql .= "UPDATE `users` SET `wallet`='$wallet' WHERE  id = '$id';";
$sql .= "COMMIT;";
$conn->exec($sql);