<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Tests;

use Andre\Bionic\Plugins\AbstractBionicPlugin;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Requests the mocked HTTP client has sent
     *
     * @var array<int, array{request: Request}>
     */
    protected array $history = [];

    /**
     * Decode a JSON fixture from tests/fixtures
     *
     * @return array<string, mixed>
     */
    protected function fixture(string $path): array
    {
        $json = file_get_contents(__DIR__ . '/fixtures/' . $path);

        $this->assertIsString($json, "Fixture $path not found");

        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Run a webhook payload through a plugin and record every event it emits
     */
    protected function receive(AbstractBionicPlugin $plugin, array $payload): RecordingBionic
    {
        $bionic = RecordingBionic::initialize();
        $bionic->setPlugin($plugin);
        $bionic->receive($payload);

        return $bionic;
    }

    /**
     * Give a plugin an HTTP client that answers with the given responses
     * and records each request in $this->history
     */
    protected function mockHttp(AbstractBionicPlugin $plugin, Response ...$responses): void
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $stack->push(Middleware::history($this->history));

        $plugin->setHttpClient(new Client([
            'handler' => $stack,
            'headers' => ['Content-Type' => 'application/json'],
        ]));
    }

    protected function lastRequest(): Request
    {
        $this->assertNotEmpty($this->history, 'No HTTP request was sent');

        return end($this->history)['request'];
    }

    /**
     * @return array<string, mixed>
     */
    protected function lastRequestJson(): array
    {
        return json_decode((string) $this->lastRequest()->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }
}
