# DashaMail PHP Client
Современная PHP-библиотека для интеграции с [DashaMail API](https://dashamail.ru/api/).

- Универсальный вызов методов API через camelCase-методы
- Актуальные параметры для всех методов API
- Строгая типизация, простая интеграция, без внешних зависимостей

## Установка

```bash
composer require geekjob/dasha-mail-client
```

или вручную добавить файлы и зарегистрировать namespace через psr-4.

## Быстрый старт

```php
use DashaMail\Client;

$client = new Client('your_api_key');

// Получить все адресные базы
$lists = $client->listsGet();

// Добавить подписчика
$result = $client->listsAddMember([
    'list_id' => 123456,
    'email'   => 'test@example.com',
]);

// Получить отчёт по рассылке
$report = $client->reportsGet([
    'campaign_id' => 5555
]);
```

## Справочник методов API

Все методы вызываются в camelCase-нотации. Например, `lists.get` → `$client->listsGet([...])`.

---

### 📋 Адресные базы (`lists`)

#### `listsGet`

Получить список всех адресных баз.

**Параметры:**
- `list_id` *(опционально)* — ID конкретной базы

#### `listsAdd`

Создать новую адресную базу.

**Параметры:**
- `name` — название базы
- `abuse_email`, `abuse_name`, `company`, `address`, `city`, `zip`, `country`, `url`, `phone` — реквизиты

#### `listsUpdate`

Обновить информацию об адресной базе.

**Параметры:**  
Та же структура, что и у `listsAdd`, обязательно указывать `list_id`.

#### `listsDelete`

Удалить адресную базу.

**Параметры:**
- `list_id` — ID удаляемой базы

#### `listsGetMembers`

Получить список подписчиков в базе.

**Параметры:**  
- `list_id`, `state`, `start`, `limit`, `order`, `member_id`, `email`, `segment_id`

#### `listsGetUnsubscribed`

Список отписавшихся подписчиков.

**Параметры:**  
- `start`, `limit`, `order`, `list_id`

#### `listsGetComplaints`

Список подписчиков, отметивших "Это Спам".

**Параметры:**  
- `start`, `limit`, `order`, `list_id`

#### `listsMemberActivity`

Получение активности подписчика.

**Параметры:**  
- `email`, `filter`, `start_time`, `end_time`, `campaign_id`

#### `listsUpload`

Импорт подписчиков из файла.

**Параметры:**  
- `list_id`, `file`, дополнительные параметры (см. [официальную документацию](https://dashamail.ru/api/))

#### `listsAddMember`

Добавить одного подписчика.

**Параметры:**  
- `list_id`, `email`, дополнительные поля

#### `listsAddMemberBatch`

Добавить несколько подписчиков.

**Параметры:**  
- `list_id`, `batch` (json), дополнительные опции

#### `listsUpdateMember`

Обновить подписчика.

**Параметры:**  
- `list_id`, `email` или `member_id`, новые значения для обновления

#### `listsDeleteMember`

Удалить подписчика.

**Параметры:**  
- `list_id`, `email` или `member_id`

---

### 📨 Рассылки (`campaigns`)

#### `campaignsGet`

Получить список рассылок.

**Параметры:**  
- `campaign_id`, `status`, `start`, `limit`, `order`, `date_from`, `date_to`

#### `campaignsAdd`

Создать новую рассылку.

**Параметры:**  
- `subject`, `from_name`, `from_email`, `body`, `list_id` и др.

#### `campaignsDelete`

Удалить рассылку.

**Параметры:**  
- `campaign_id`

---

### 📈 Отчёты (`reports`)

#### `reportsGet`

Получить отчёт по рассылке.

**Параметры:**  
- `campaign_id`

#### `reportsGetClicks`

Клики по ссылкам в рассылке.

**Параметры:**  
- `campaign_id`

#### `reportsGetViews`

Открытия рассылки.

**Параметры:**  
- `campaign_id`

---

### 👤 Аккаунт (`account`)

#### `balance`

Проверить текущий баланс аккаунта.

**Параметры:**  
(нет)

#### `ping`

Проверка работоспособности API (вернет `pong`).

**Параметры:**  
(нет)

---

## Примеры
```php
// Получить баланс
$balance = $client->balance();

// Проверить доступность API
$pong = $client->ping();

// Создать рассылку
$newCampaign = $client->campaignsAdd([
    'subject'    => 'Новинка',
    'from_name'  => 'Маркетинг',
    'from_email' => 'info@yourdomain.com',
    'body'       => 'Текст письма',
    'list_id'    => 11111
]);
```

## Официальная документация
Актуальный список параметров и полный список методов — на сайте  
[https://dashamail.ru/api/](https://dashamail.ru/api/)

## Лицензия
- [MIT License](LICENSE)
