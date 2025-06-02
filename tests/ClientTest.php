<?php declare(strict_types=1);

namespace DashaMail\Tests;

use DashaMail\Client;
use DashaMail\Exception;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Client.php';
require_once __DIR__ . '/../src/Exception.php';
require_once __DIR__ . '/curl_stub.php';

final class ClientTest extends TestCase
{
    protected function setUp(): void
    {
        \DashaMail\CurlStub::reset();
    }

    public function testSuccessfulCallReturnsData(): void
    {
        \DashaMail\CurlStub::$response = json_encode(['code' => 0, 'data' => ['ok' => true]]);

        $client = new Client('key');

        $result = $client->listGet(['page' => 1]);

        $this->assertSame(['ok' => true], $result);

        $fields = [];
        parse_str(\DashaMail\CurlStub::$options[CURLOPT_POSTFIELDS], $fields);

        $this->assertSame('key', $fields['api_key']);
        $this->assertSame('list.get', $fields['method']);
        $this->assertSame('json', $fields['format']);
        $this->assertSame('1', $fields['page']);
    }

    public function testCurlErrorThrowsException(): void
    {
        \DashaMail\CurlStub::$response = false;
        \DashaMail\CurlStub::$error = 'timeout';

        $client = new Client('key');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Curl error: timeout');

        $client->listGet();
    }

    public function testInvalidJsonThrowsException(): void
    {
        \DashaMail\CurlStub::$response = '{invalid';

        $client = new Client('key');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Ошибка декодирования JSON');

        $client->listGet();
    }

    public function testApiErrorThrowsException(): void
    {
        \DashaMail\CurlStub::$response = json_encode(['code' => 123, 'message' => 'bad']);

        $client = new Client('key');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('bad');

        $client->listGet();
    }
}

