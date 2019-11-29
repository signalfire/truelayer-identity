<?php

declare(strict_types=1);

namespace Signalfire\TrueIdentity\Tests;

use PHPUnit\Framework\TestCase;
use Mockery;

use Signalfire\TrueIdentity\Auth;
use Signalfire\TrueIdentity\Credentials;
use Signalfire\TrueIdentity\Request;

final class AuthTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function testAuthHasMethods()
    {
        $request = Mockery::mock(Request::class);

        $credentials = new Credentials('ABC', '123');

        $auth = new Auth($request, $credentials);
        
        $this->assertTrue(method_exists($auth, 'getAccessToken'));
        $this->assertTrue(method_exists($auth, 'getRefreshedAccessToken'));
    }

    public function testAuthGetAccessToken()
    {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('makeRequest')
            ->withArgs([
                '/connect/token',
                'POST',
                [
                    'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
                    'form_params' => [
                        'client_id' => 'ABC',
                        'client_secret' => '123',
                        'code' => 'ZXY',
                        'redirect_uri' => 'https://console.truelayer.com/redirect-page',
                        'grant_type' => 'authorization_code'
                    ]
                ]
            ])
            ->times(1)
            ->andReturn([]);

        $credentials = new Credentials('ABC', '123');

        $auth = new Auth($request, $credentials);

        $response = $auth->getAccessToken('ZXY', 'https://console.truelayer.com/redirect-page');
        
        $this->assertIsArray($response);
    }
}
