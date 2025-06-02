<?php declare(strict_types=1);

namespace DashaMail
{
  use JsonException;
  use DashaMail\Exception;

  final class Client
  {
      private const string BASE_URL = 'https://api.dashamail.ru/';
      private const int TIMEOUT = 10;
  
      public function __construct(
          private readonly string $apiKey,
          private readonly ?string $format = 'json',
      ) {}
  
      /**
       * Универсальный вызов методов API через camelCase: $client->listGet([...])
       * Преобразует camelCase в dashamail-style (list.get, message.send, ...)
       *
       * @param string $name    Имя метода в camelCase (например, listGet, messageSend)
       * @param array<mixed> $arguments Параметры метода (один массив)
       * @return array|null
       * @throws Exception
       */
      public function __call(string $name, array $arguments): array|null
      {
          // camelCase => dashamail-style: listGet → list.get
          $method = strtolower(preg_replace('/([a-z])([A-Z])/', '$1.$2', $name));
  
          $params = $arguments[0] ?? [];
  
          $postFields = array_merge([
              'api_key' => $this->apiKey,
              'method'  => $method,
              'format'  => $this->format,
          ], $params);
  
          $ch = curl_init(self::BASE_URL);
          curl_setopt_array($ch, [
              CURLOPT_POST => true,
              CURLOPT_POSTFIELDS => http_build_query($postFields),
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_TIMEOUT => self::TIMEOUT,
          ]);
          $result = curl_exec($ch);
  
          if ($result === false) {
              throw new Exception('Curl error: ' . curl_error($ch));
          }
          $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
          curl_close($ch);
  
          try {
              $response = json_decode($result, true, 512, JSON_THROW_ON_ERROR);
          } catch (JsonException $e) {
              throw new Exception('Ошибка декодирования JSON: ' . $e->getMessage());
          }
  
          $code = (int)($response['code'] ?? $httpCode);
          $message = $response['message'] ?? 'Unknown error';
  
          if ($code !== 0) {
              throw new Exception($message, $response, $code);
          }
  
          return $response['data'] ?? null;
      }
  }
}
