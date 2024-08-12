<?php
//подключаем файл с функциями
require_once("functions.php");

//подключаем базу
$mysqli = require("db.php");

//проверям что поле age не пустое
if (!isset($_POST["age"]) or empty($_POST["age"])) {
    http_response_code(403);
    echo json_encode([
        "error" => "Обязательный параметр age"
    ]);
    exit();
}

//проверям что поле age положительное число
if (!is_int($_POST["age"]) or $_POST["age"] <= 0) {
    http_response_code(403);
    echo json_encode([
        "error" => "age должно быть положительным числом!"
    ]);
    exit();
}

$user = getUserOrFail();
$user_id = $user["id"];
$age = $_POST["age"];

//обновляем в базе: данные age по id пользователя
$sql = "UPDATE users SET age = ? WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $age, $user_id);
$stmt->execute();

$user = getUser();

echo json_encode([
    "data" => $user
]);
