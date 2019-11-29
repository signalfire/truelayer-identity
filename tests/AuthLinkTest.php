<?php

declare(strict_types=1);

namespace Signalfire\TrueIdentity\Tests;

use PHPUnit\Framework\TestCase;

use Signalfire\TrueIdentity\Credentials;
use Signalfire\TrueIdentity\AuthLink;

final class AuthLinkTest extends TestCase
{
    public function testAuthLinkHasMethods()
    {
        $credentials = new Credentials('ABC', '123');

        $link = new AuthLink($credentials, 'http://test.com', 'ABC', true);
        
        $this->assertTrue(method_exists($link, 'getAuthLinkUri'));
    }

    public function testAuthLinkUriSandbox()
    {
        $credentials = new Credentials('ABC', '123');

        $link = new AuthLink($credentials, 'http://test.com', 'DEF', true);

        $uri = $link->getAuthLinkUri();

        $this->assertIsString($uri);

        $parts = explode('?', $uri);
        $params = explode('&', end($parts));

        $this->assertEquals($parts[0], 'https://auth.truelayer-sandbox.com');

        foreach ($params as $param) {
            $data = explode('=', $param);
            switch (strtolower($data[0])) {
                case 'client_id':
                    $expected = 'ABC';
                    break;
                case 'redirect_uri':
                    $expected = urlencode('http://test.com');
                    break;
                case 'state':
                    $expected = 'DEF';
                    break;
                case 'response_mode':
                    $expected = 'form_post';
                    break;
                case 'enable_mock':
                    $expected = 'true';
                    break;
                case 'response_type':
                    $expected = 'code';
                    break;
                case 'scope':
                    $expected = 'info';
                    break;
                default:
                    $expected = null;
                    break;
            }
            if (isset($expected)) {
                $this->assertEquals($data[1], $expected);
            }
        }
    }

    public function testAuthLinkUriLive()
    {
        $credentials = new Credentials('ABC', '123');

        $link = new AuthLink($credentials, 'http://test.com', 'DEF', false);

        $uri = $link->getAuthLinkUri();

        $this->assertIsString($uri);

        $parts = explode('?', $uri);
        $params = explode('&', end($parts));

        $this->assertEquals($parts[0], 'https://auth.truelayer.com');

        foreach ($params as $param) {
            $data = explode('=', $param);
            switch (strtolower($data[0])) {
                case 'client_id':
                    $expected = 'ABC';
                    break;
                case 'redirect_uri':
                    $expected = urlencode('http://test.com');
                    break;
                case 'state':
                    $expected = 'DEF';
                    break;
                case 'response_mode':
                    $expected = 'form_post';
                    break;
                case 'enable_mock':
                    $expected = 'false';
                    break;
                case 'response_type':
                    $expected = 'code';
                    break;
                case 'scope':
                    $expected = 'info';
                    break;
                default:
                    $expected = null;
                    break;
            }
            if (isset($expected)) {
                $this->assertEquals($data[1], $expected);
            }
        }
    }
}
