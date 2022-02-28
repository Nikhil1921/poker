<?php
require_once "conn.php";

extract($_POST);

if ($win == 'true')
    $wallet = $user['wallet'] + $money;
else
    $wallet = $user['wallet'] - $money;

$sql = "START TRANSACTION;";
$sql .= "UPDATE `game_logs` SET ";
$sql .= ($win == 'true') ? "`game_win` = '1', `win_money` = '$money'" : "`lost_money` = '$money'";
$sql .= " , `over_type` = 'Raise' WHERE  game_id = '$gameId';";
$sql .= "UPDATE `users` SET `wallet`='$wallet' WHERE  id = '$id';";
$sql .= "COMMIT;";

$conn->exec($sql);