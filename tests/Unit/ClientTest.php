<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit;

use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private const API_KEY = 'pdl_sdbx_apikey_01jkdpbhazdpn3wpcya45as9tg_clientsecret_abc';

    /**
     * @test
     *
     * @dataProvider debugOutputProvider
     */
    public function it_keeps_the_api_key_out_of_debug_output(\Closure $dump): void
    {
        $client = new Client(apiKey: self::API_KEY, options: new Options(Environment::SANDBOX), httpClient: new MockClient());

        $output = $dump($client);

        self::assertStringContainsString('options', $output);
        self::assertStringNotContainsString('clientsecret', $output);
    }

    public static function debugOutputProvider(): \Generator
    {
        yield 'var_dump' => [function (Client $client): string {
            ob_start();
            var_dump($client);

            return (string) ob_get_clean();
        }];
        yield 'print_r' => [fn (Client $client): string => print_r($client, true)];
        yield 'print_r of a resource client' => [fn (Client $client): string => print_r($client->products, true)];
    }
}
