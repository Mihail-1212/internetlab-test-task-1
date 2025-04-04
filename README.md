# Test project - symfony application

## Project setup

1. Clone repo
2. Install composer requirements
```
composet install
```
P.S. Can be composer error "Your lock file does not contain a compatible set of packages. Please run composer update."
\
Then run:
```
composer update --ignore-platform-reqs
```
3. Migrate
```
php bin/console doctrine:migrations:migrate
```
4. Run server
```
symfony server:start
```

### Requirements
- php - 8.4.5
- Composer - 2.8.7
- Symfony (cli) - 5.11.0 

Routes:
### /api/user

#### GET
##### Description:
Получить список пользователей
##### Responses
| Code | Description |
| ---- | ----------- |
| 200 | OK |

#### POST
##### Description:
Создание нового пользователя
##### Responses
| Code | Description |
| ---- | ----------- |
| 200 | OK |

### /api/user/{id} (требуется авторизация)

#### PUT
##### Description:
Обновить пользователя по ID
##### Parameters
| Name | Located in | Description | Required | Schema |
| ---- | ---------- | ----------- | -------- | ---- |
| id | path | ID пользователя | Yes | number |
##### Responses
| Code | Description |
| ---- | ----------- |
| 200 | OK |
| 401 | Unauthorized |
| 404 | Not found |

#### DELETE
##### Description:
Удалить пользователя по ID
##### Parameters
| Name | Located in | Description | Required | Schema |
| ---- | ---------- | ----------- | -------- | ---- |
| id | path | ID пользователя | Yes | number |
##### Responses
| Code | Description |
| ---- | ----------- |
| 200 | OK |
| 401 | Unauthorized |
| 404 | Not found |

### /api/user/me (требуется авторизация)
#### GET
##### Description:
Получение информации о текущем пользователе
##### Responses
| Code | Description |
| ---- | ----------- |
| 200 | OK |
| 401 | Unauthorized |

### /api/user/changePassword

#### POST
##### Description:
Изменение пароля текущего пользователя
##### Responses
| Code | Description |
| ---- | ----------- |
| 200 | OK |
| 401 | Unauthorized |
| 422 | Unprocessable Entity |

За подробностями - см. openapi.yaml
