# Delivery Service

Сервис на Laravel для управления доставкой и заказами.

## О проекте

`Delivery Service` - REST API на Laravel.

## Стек

- PHP 8.4
- Laravel 10
- Laravel Sanctum
- PostgreSQL 16
- Docker Compose

## Возможности

- регистрация пользователя;
- логин и выдача Bearer token;
- получение текущего пользователя;
- logout с удалением текущего token;
- CRUD заказов;
- публичный трекинг заказа по ID;
- расчет стоимости заказа по формуле `price = weight * 120`;
- статусы заказа: `created`, `accepted`, `in_transit`, `delivered`.

## Структура

```text
app/
  Http/
    Controllers/Api     # HTTP handlers
    Requests            # валидация входящих JSON-запросов
  Models                # Eloquent-модели
config/                 # конфигурация Laravel
database/migrations     # схема БД
routes/api.php          # API routes
```

## Запуск через Docker

Собрать и запустить контейнеры:

```bash
docker compose up --build
```

Приложение будет доступно на:

```text
http://localhost:8000
```

В отдельном терминале выполнить миграции:

```bash
docker compose exec app php artisan migrate
```

Проверить health endpoint:

```bash
curl http://localhost:8000/api/health
```

Ожидаемый ответ:

```json
{"status":"ok"}
```

## API

### Регистрация

```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Ivan",
    "email": "ivan@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

В ответе будет `token`. Его нужно передавать в защищенные endpoints:

```bash
TOKEN="paste_token_here"
```

### Логин

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "ivan@example.com",
    "password": "password123"
  }'
```

### Текущий пользователь

```bash
curl http://localhost:8000/api/me \
  -H "Authorization: Bearer $TOKEN"
```

### Создание заказа

```bash
curl -X POST http://localhost:8000/api/orders \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d '{
    "sender_name": "Ivan",
    "recipient_name": "Petr",
    "origin_city": "Novosibirsk",
    "destination_city": "Moscow",
    "weight": 2.5,
    "comment": "Handle carefully"
  }'
```

При весе `2.5` цена будет рассчитана автоматически:

```text
2.5 * 120 = 300
```

### Список заказов

```bash
curl http://localhost:8000/api/orders \
  -H "Authorization: Bearer $TOKEN"
```

### Просмотр заказа

```bash
curl http://localhost:8000/api/orders/1 \
  -H "Authorization: Bearer $TOKEN"
```

### Обновление заказа

```bash
curl -X PATCH http://localhost:8000/api/orders/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d '{
    "status": "in_transit"
  }'
```

### Трекинг заказа

Трекинг публичный, token не нужен:

```bash
curl http://localhost:8000/api/orders/1/track
```

### Удаление заказа

```bash
curl -X DELETE http://localhost:8000/api/orders/1 \
  -H "Authorization: Bearer $TOKEN"
```

### Logout

```bash
curl -X POST http://localhost:8000/api/logout \
  -H "Authorization: Bearer $TOKEN"
```

## Полезные команды

```bash
docker compose exec app php artisan route:list
docker compose exec app php artisan migrate:fresh
docker compose logs app -f
docker compose down -v
```
