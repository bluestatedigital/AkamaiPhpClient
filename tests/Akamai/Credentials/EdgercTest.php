<?php

namespace Akamai\Credentials\Tests;

use Akamai\Credentials\Edgerc;

class EdgercTest extends \PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        $nonExistentSectionConfig = <<<EDGERC
[foo]
host = foobar.com
EDGERC;

        $configWithoutCredentials = <<<EDGERC
[default]
host = foobar.com
EDGERC;

        $validConfig = <<<EDGERC
[default]
host = foobar.com
client_token = quux
client_secret = baz
access_token = booz
EDGERC;

        file_put_contents('/tmp/edgerc-missing-section-config', $nonExistentSectionConfig);
        file_put_contents('/tmp/edgerc-no-credentials-config', $configWithoutCredentials);
        file_put_contents('/tmp/edgerc-valid-config', $validConfig);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testMissingSectionConfig()
    {
        $credentials = new \Akamai\Credentials\Edgerc('default', '/tmp/edgerc-missing-section-config');
    }

    public function testMissingCredentialsConfig()
    {
        $credentials = new \Akamai\Credentials\Edgerc('default', '/tmp/edgerc-no-credentials-config');
        $this->assertEquals($credentials->getHost(), 'foobar.com');
        $this->assertEmpty($credentials->getClientToken());
        $this->assertEmpty($credentials->getClientSecret());
        $this->assertEmpty($credentials->getAccessToken());
    }

    public function testValidConfig()
    {
        $credentials = new \Akamai\Credentials\Edgerc('default', '/tmp/edgerc-valid-config');
        $this->assertEquals($credentials->getHost(), 'foobar.com');
        $this->assertEquals($credentials->getClientToken(), 'quux');
        $this->assertEquals($credentials->getClientSecret(), 'baz');
        $this->assertEquals($credentials->getAccessToken(), 'booz');
    }
}
