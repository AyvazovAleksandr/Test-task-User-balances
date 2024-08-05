# Тестовое задание Балансы пользователей

## Порядок запуска

### Скопировать .env для Докера

```sh
cp .env.example .env
```

### Скопировать .env для Laravel

```sh
cd www/test.local/
cp .env.example .env
```

### Запустить проект

```sh
docker-compose  up -d
```

### Настроить проект

```sh
docker-compose exec php bash
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```

### Запустить фронт проекта

```sh
cd www/test.local/
npm install && npm run dev
```

### Пользоваться проектом

Перейти по ссылке http://localhost/

## Команды проекта

### Создание пользователя

```sh
docker-compose exec php bash
php artisan app:add-user User user@mail.ru 123456
```

### Добавить средства

```sh
docker-compose exec php bash
php artisan app:add-transaction user@mail.ru add 66.02 Add1
```

### Списать средства

```sh
docker-compose exec php bash
php artisan app:add-transaction user@mail.ru subtract 10.02 Sub1
```
