## Проект онлайн школы

функционал:
- создание/измениение/удаление курсов
- создание/измениение/удаление уроков в курсе

## пример работающего приложения



## спецификации

хлебные крошки для удобной навигации
- https://github.com/asternov/school/blob/master/routes/breadcrumbs.php

компонент vue js для удобной вставки видео с youtube
- https://github.com/asternov/school/blob/master/resources/js/components/youtube.vue

в качестве радактора текста используется tinymce
- https://github.com/asternov/school/blob/master/resources/js/components/tinymce.vue

вложения к урокам
https://github.com/asternov/school/blob/master/app/Http/Controllers/AttachmentController.php

рекурсивные комментарии
https://github.com/asternov/school/blob/master/resources/views/partials/replies.blade.php

## Установка на серевер

- Клонируем репозиторий
- `git clone https://github.com/asternov/school.git`
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
