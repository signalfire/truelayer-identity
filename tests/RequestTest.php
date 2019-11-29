<?php

declare(strict_types=1);

namespace Signalfire\TrueIdentity\Tests;

use PHPUnit\Framework\TestCase;

use Signalfire\TrueIdentity\Request;

final class RequestTest extends TestCase
{
    public function testRequestHasMethods()
    {
        $request = new Request;
        
        $this->assertTrue(method_exists($request, 'makeRequest'));
    }

    public function testRequestSuccess()
    {
        $request = new Request;

        $response = $request->makeRequest('https://google.com', 'GET');
        $this->assertIsArray($response);
        $this->assertArrayHasKey('statusCode', $response);
        $this->assertArrayHasKey('reason', $response);
        $this->assertArrayHasKey('body', $response);
    }

    public function testRequestException()
    {
        $request = new Request;

        $response = $request->makeRequest('http://kTr07Vi0sD.kTr0', 'GET');

        $this->assertIsArray($response);
        $this->assertArrayHasKey('error', $response);
        $this->assertArrayHasKey('reason', $response);
    }
}
