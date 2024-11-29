
## Гостевая книга



- [User Agent для Laravel](https://github.com/jenssegers/agent).
- [Captcha для Laravel 10/11](https://github.com/mewebstudio/captcha?tab=readme-ov-file).

## Стек

- PHP 8.1.9
- Composer version 2.5.1
- Laravel Version 10.48.25
- Данные для подключения к БД находятся в файле .env 
- Дамп базы лежит в директории /public 


## Запуск проекта

- После изменения файла .env, указав корректные данные вашей БД, если вы не хотите использовать мой дамп базы, можете воспользоваться командой
```php
    php artisan migrate
```
- тем самым создав миграцию с созданием нужных для работы таблиц
- После настройки базы и создания нужных таблиц, можно запустить проект командой:
```php
    php artisan serve
```



