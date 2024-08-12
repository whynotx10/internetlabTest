1. Создание пользователя:

POST /reg.php на вход принимает login, password. 
```
{
    "data": {
        "id": 2,
        "login": "alex2",
        "age": null,
        "token": "OjRhoFgsUBav1Tdw"
    }
}
```
---
2. Авторизация пользователя:

POST /auth.php на вход принимает login, password.
```
{
    "data": {
        "id": 2,
        "login": "alex2",
        "age": null,
        "token": "OjRhoFgsUBav1Tdw"
    }
}
```
---
3. Получить информацию о пользователе:

GET /get_user.php?user_id=3 на вход принимает user_id (опциональный параметр). 

**Требуется авторизация Bearer Token.**
```
{
    "data": {
        "id": 2,
        "login": "alex2",
        "age": null
    }
}
```
---
4. Обновление информации о пользователе:

POST /update_user.php на вход принимает age. 

**Требуется авторизация Bearer Token.**
```
{
    "data": {
        "id": 2,
        "login": "alex2",
        "age": 27
    }
}
```
---
5. Удаление пользователя:

DELETE /delete_user.php 

**Требуется авторизация Bearer Token.**
```
{
    "data": true
}
```
---
Пример ошибки:
```
{
    "error": "Требуется авторизация!"
}
```
