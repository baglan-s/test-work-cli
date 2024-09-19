Вот обновлённый `README.md` файл с изменением базы данных на PostgreSQL:

---

# Проект на Laravel с использованием Docker

## Описание

Этот проект представляет собой приложение на Laravel, работающее внутри Docker-контейнеров. Проект предоставляет возможность управления пользователями и их балансами через консольные команды.

## Стек технологий

- **PHP** (Laravel)
- **Docker**
- **PostgreSQL** (вместо MySQL)
- **Docker Compose**

## Запуск проекта

Для сборки и запуска проекта используйте Docker Compose. Убедитесь, что у вас установлен Docker и Docker Compose.

### 1. Сборка и запуск контейнеров

Запустите следующую команду для сборки и запуска всех контейнеров в фоновом режиме:

```bash
docker compose up -d
```

### 2. Запуск миграций

После того как контейнеры запущены, выполните миграции для создания необходимых таблиц в базе данных:

```bash
docker exec -t cli-php php artisan migrate
```

### 3. Доступ к проекту

Проект будет доступен по следующему адресу:

```
http://localhost:7005
```

## Управление пользователями и балансом

После успешного запуска контейнеров вы можете создавать пользователей и управлять их балансом через консольные команды Laravel. Для этого выполните следующие шаги:

### 1. Вход в контейнер с PHP

Используйте следующую команду для входа в контейнер:

```bash
docker exec -it cli-php sh
```

После входа в контейнер вам станут доступны следующие команды:

### 2. Команды для управления пользователями и балансом

#### Создание нового пользователя

```bash
php artisan user:create
```

#### Добавление средств на баланс пользователя

```bash
php artisan user:balance-add
```

#### Списание средств с баланса пользователя

```bash
php artisan user:balance-remove
```

## Заключение

Этот проект позволяет легко управлять пользователями и их балансами с помощью простых команд внутри контейнеров Docker, используя PostgreSQL для хранения данных.

Если у вас есть вопросы или предложения, пожалуйста, создайте issue в этом репозитории.

---

## Лицензия

Этот проект распространяется под лицензией [MIT](LICENSE).

---

Теперь ваш `README.md` включает информацию о работе с базой данных PostgreSQL.