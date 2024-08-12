<?php
//подключаем базу
$mysqli = require_once("db.php");

//проверям что поля login и password не пустые
if (!isset($_POST["login"]) or !isset($_POST["password"]) or empty($_POST["login"]) or empty($_POST["password"])) {
    http_response_code(403);
    echo json_encode([
        "error" => "Обязательные параметры login, password"
    ]);
    exit();
}

//вытаскиваем из базы данные о пользователе
$login = $_POST["login"];
$sql = "SELECT * FROM users WHERE login = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $login);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

//проверяем что пользователь существует
if ($result == null) {
    http_response_code(403);
    echo json_encode([
        "error" => "Такого логина не существует"
    ]);
    exit();
}

//проверяем пароль
$hash = hash("sha256", $_POST["password"]);

if ($hash !== $result["password"]) {
    http_response_code(403);
    echo json_encode([
        "error" => "Неверный пароль"
    ]);
    exit();
}

unset($result["password"]);
echo json_encode([
    "data" => $result
]);