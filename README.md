# Afisha

### Описание проекта
Проект **Afisha** — это веб-приложение для отображения мероприятий и управления пользователями, реализованное на **Laravel 11**. Пользователи могут регистрироваться, подписываться на события, а администраторы управляют событиями через специальную панель. Также реализована система верификации email после регистрации.

### Основные возможности:
- Все посетители сайта могут просматривать опубликованные мероприятия.
- Регистрация и авторизация пользователей с подтверждением через email.
- Подписка на мероприятия и отмена подписки для зарегистрированных пользователей.
- Пользовательский и административный кабинеты.
- Управление мероприятиями, категориями, пользователями для администратора.
- Поиск по сайту

### Данные:
База собирается из миграций, запускаются сидеры, которые наполняют базу контентом.

Предустановленные пользователи для быстрой проверки функционала.
```
name: Admin
email: admin@mail.com
password: admin
```
```
name: User
email: user@mail.com
password: user
```
```
Пользователь с отключенной учетной записью
name: UserBlock
email: userblock@mail.com
password: user
isActive: false
```


### Технологии:
- **Backend**: PHP, Laravel 11, PostgresSQL
- **Frontend**: Tailwind CSS (через CDN)

### Установка

1. Склонируйте репозиторий:
    ```bash
    git clone https://github.com/romanfd/afisha.git
    cd afisha
    ```

2. Установите зависимости Composer:
    ```bash
    composer install
    ```

3. Создайте файл `.env` и настройте его:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. Настройте базу данных и другие параметры в файле `.env`.

5. Выполните миграции базы данных и заполните тестовыми данными:
    ```bash
    php artisan migrate --seed
    ```

6. Настройте отправку почты (например, используя SMTP от Gmail) в файле `.env`:
    ```env
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=ваш_email@gmail.com
    MAIL_PASSWORD=ваш_пароль
    MAIL_ENCRYPTION=tls
    ```

### Использование

1. Запустите локальный сервер:
    ```bash
    php artisan serve
    ```

2. Перейдите по адресу http://localhost:8000 в браузере для доступа к приложению.

### Примечания

- В проекте используется **Tailwind CSS**, подключенный через CDN, без использования npm.

### Дополнительные команды

- Очистка кэша конфигурации:
    ```bash
    php artisan config:cache
    ```

- Очистка сессий, маршрутов и представлений:
    ```bash
    php artisan cache:clear
    php artisan route:clear
    php artisan view:clear
    ```
