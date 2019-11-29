<?php

declare(strict_types=1);

namespace Signalfire\TrueIdentity\Tests;

use PHPUnit\Framework\TestCase;
use Mockery;

use Signalfire\TrueIdentity\Request;
use Signalfire\TrueIdentity\Info;

final class InfoTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function testInfoHasMethods()
    {
        $request = Mockery::mock(Request::class);

        $info = new Info($request, 'ABC');
        
        $this->assertTrue(method_exists($info, 'getInfo'));
    }

    public function testGetInfo()
    {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('makeRequest')
            ->withArgs([
                '/data/v1/info',
                'GET',
                [
                  'headers' => ['Authorization' => sprintf('Bearer %s', 'ABC')],
                ]
            ])
            ->times(1)
            ->andReturn([]);

        $info = new Info($request, 'ABC');

        $response = $info->getInfo();
        
        $this->assertIsArray($response);
    }
}
