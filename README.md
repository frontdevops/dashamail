# DashaMail PHP Client

Современный PHP 8.3+ клиент для работы с API [DashaMail](https://dashamail.ru/api/).

- Универсальный вызов любых методов API через camelCase-методы
- Без зависимостей, строгое типизирование, простота интеграции
- Актуально для любых версий API DashaMail — методы не требуют ручного описания

## Установка
```bash
composer ...
```

## Быстрый старт
```php
use DashaMail\Client;
use DashaMail\Exception;

$client = new Client(apiKey: 'your_api_key');

try {
    // Получить баланс
    $balance = $client->balance();

    // Получить все списки
    $lists = $client->listGet();

    // Добавить новый список
    $listId = $client->listAdd(['name' => 'Моя рассылка']);

    // Удалить список
    $client->listDelete(['list_id' => $listId]);

    // Отправить письмо (пример)
    $result = $client->messageSend([
        'subject' => 'Тест',
        'body' => 'Текст письма',
        // другие параметры по API...
    ]);
} catch (Exception $e) {
    // Обработка ошибок
    echo $e->getMessage();
    // print_r($e->response); // Полный ответ API
}
```

## Особенности
- Любой метод API вызывается просто:
  `$client->listGet([...]), $client->messageSend([...]) и т.д.`
- Имена методов — camelCase, параметры — массив как в документации.
- Автоматическая обработка ошибок API и HTTP.
- Расширять/поддерживать не нужно — все методы и параметры динамически прокидываются.

## Совместимость
- PHP 8.3 и выше.
- Без сторонних зависимостей (только стандартные расширения PHP).

## Документация DashaMail
Подробности методов, параметров и примеры — на официальной странице:
https://dashamail.ru/api/
