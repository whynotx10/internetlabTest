<?php
function getUser(): array|null
{
    //подключаем базу
    $mysqli = require("db.php");

    //вытаскиваем из базы данные о пользователе
    $token = getBearerToken();

    //если токен пустой, то пользователь не найден
    if ($token == null) {
        return null;
    }

    $sql = "SELECT id, login, age FROM users WHERE token = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

/**
 * Получить пользователя или отдать ошибку 401
 * @return array|null
 */
function getUserOrFail(): array|null
{
    $user = getUser();
    if ($user == null) {
        http_response_code(401);
        echo json_encode([
            "error" => "Требуется авторизация!"
        ]);
        exit();
    }
    return $user;
}

/**
 * Получить токен из header
 * @return string|null
 */
function getBearerToken(): ?string
{
    $headers = array_change_key_case(getallheaders(), CASE_LOWER);
    if (!isset($headers['authorization'])) {
        return null;
    }

    return trim(str_replace('Bearer', '', $headers['authorization']));
}