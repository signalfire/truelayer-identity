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
    }

    public function testAuthLinkUriLive()
    {
        $credentials = new Credentials('ABC', '123');

        $link = new AuthLink($credentials, 'http://test.com', 'DEF', false);

        $uri = $link->getAuthLinkUri();

        $this->assertIsString($uri);
    }
}
