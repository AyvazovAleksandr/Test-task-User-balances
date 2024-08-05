### Пересобрать проект
```sh
docker-compose -f docker-compose.local.yml up -d --no-deps --build nginx
```

### Установить библиотеки из Composer

```sh
docker-compose -f docker-compose.local.yml run --rm composer install
```

### Запустить любую команду artisan
```sh
docker-compose -f docker-compose.local.yml run --rm artisan <comands>
```

### Запустить команду composer
```sh
docker-compose -f docker-compose.local.yml run --rm composer <comands>
```

### Зайти в контейнер PHP 
```sh
docker-compose -f docker-compose.local.yml exec php bash

```

### Очистить кэш
```sh
php artisan  optimize:clear
```

### Запустить миграции
```sh
php artisan migrate
```

### Перезапустить supervisor
```sh
docker-compose -f docker-compose.local.yml restart supervisor
```


