<?php

namespace Sujip\GeoIp\Test;

use PHPUnit\Framework\TestCase;
use Sujip\GeoIp\Exception\Forbidden;
use Sujip\GeoIp\GeoIp;
use Sujip\GeoIp\Response;

/**
 * Class GeoIpTest
 */
class GeoIpTest extends TestCase
{
    /**
     * @var mixed
     */
    private $payload;

    public function setUp()
    {
        $this->payload = file_get_contents(__DIR__ . '/Mock/Response/response.json');
    }

    public function tearDown()
    {
        $this->payload = null;
    }

    public function testShouldThrowExceptionForEmptyIpHost()
    {
        $this->expectException(Forbidden::class);
        $this->expectExceptionMessage('No IP or hostname is provided');
        $this->expectExceptionCode(403);

        $geo = new GeoIp();
    }

    public function testShouldThrowExceptionForInvalidIpHost()
    {
        $this->expectException(Forbidden::class);
        $this->expectExceptionMessage('Forbidden');
        $this->expectExceptionCode(403);

        $geo = new GeoIp('http://localhost');
    }

    public function testShouldReturnValidResponse()
    {
        $body = $this->payload;

        $result = (new Response($body))->getBody();

        $body = json_decode($body, true);

        $this->assertEquals($body, $result);
    }
}
