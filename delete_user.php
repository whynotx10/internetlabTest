<?php
//подключаем файл с функциями
require_once("functions.php");

//подключаем базу
$mysqli = require("db.php");

$user = getUserOrFail();
$user_id = $user["id"];

//удаляем из базы user по id
$sql = "DELETE FROM users WHERE id = ?;";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $user_id);

//возвращаем статус операции
echo json_encode([
    "data" => $stmt->execute()
]);