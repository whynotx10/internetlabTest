<?php
function generateRandomString($length = 16)
{
    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
}

//подключаем базу
$mysqli = require("db.php");

//проверям что поля login и password не пустые
if (!isset($_POST["login"]) or !isset($_POST["password"]) or empty($_POST["login"]) or empty($_POST["password"])) {
    http_response_code(403);
    echo json_encode([
        "error" => "Обязательные параметры login, password"
    ]);
    exit();
}

//проверяем что такого логина нет в базе
$login = $_POST["login"];

$sql = "SELECT * FROM users WHERE login = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $login);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    http_response_code(403);
    echo json_encode([
        "error" => "Такой логин уже существует"
    ]);
    exit();
}

//регистрация пользователя
$hash = hash("sha256", $_POST["password"]);
$token = generateRandomString();
$sql = "INSERT INTO users (login, password, token) VALUES  (?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $login, $hash, $token);
$stmt->execute();

$sql = "SELECT * FROM users WHERE login = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $login);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

unset($result["password"]);
echo json_encode([
    "data" => $result
]);