<?php

//подключаем файл с функциями
require_once("functions.php");

//подключаем базу
$mysqli = require("db.php");

$user = getUserOrFail();

//если есть GET-параметр user_id, вытаскиваем этого пользователя
if (isset($_GET["user_id"])) {
    $user_id = $_GET["user_id"];

    $sql = "SELECT id, login, age FROM users WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    //в случае отсутствия пользователя выдаем ошибку 404
    if ($user == null) {
        http_response_code(404);
        echo json_encode([
            "error" => "Пользователь не найден!"
        ]);
        exit();
    }
}

echo json_encode([
    "data" => $user
]);

