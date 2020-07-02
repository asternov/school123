## Проект онлайн школы

функционал:
- создание/измениение/удаление курсов
- создание/измениение/удаление уроков в курсе

## спецификации

хлебные крошки для удобной навигации
-https://github.com/asternov/school/blob/master/routes/breadcrumbs.php


## Установка на серевер

- Клонируем репозиторий
- `git clone https://github.com/asternov/events.git`
- `cd events`
- Устанавливаем зависимости
- `composer install`
- `npm install`
- Создаем файл с переменными окружения 
- `cp .env.example .env`

- Генерируем ключ приложения
- `php artisan key:generate`

- устанвливаем переменные окружения в файле .env
- `DB_DATABASE={название бд}`
- `DB_USERNAME={имя пользователя}`
- `DB_PASSWORD={пароль}`

- накатываем миграции и записываем данные в бд
- `php artisan migrate`
- `php artisan db:seed`
- генерируем токен для авторизации Laravel Passport
- `php artisan passport:install`
- запускаем тесты
- `php artisan test`

Готово. api установленно и готово к работе
