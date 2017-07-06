<?php
/**
 * Created by PhpStorm.
 * User: qbik
 * Date: 06.07.2017
 * Time: 14:26
 */

namespace GenesisGlobal\Salesforce\Tests\Authentication;


use GenesisGlobal\Salesforce\Authentication\SalesforceAuthenticatorUrlGenerator;
use PHPUnit\Framework\TestCase;

class SalesforceAuthenticatorUrlGeneratorTest extends TestCase
{
    public function testGetUrl()
    {
        $endpoint = 'http://test-url.com';
        $expectedUrl = $endpoint . '/services/oauth2/token';

        $urlGenerator = new SalesforceAuthenticatorUrlGenerator($endpoint);

        $this->assertEquals($expectedUrl, $urlGenerator->getUrl());

        $endpoint = 'http://test-url.com/';
        $urlGenerator = new SalesforceAuthenticatorUrlGenerator($endpoint);
        $this->assertEquals($expectedUrl, $urlGenerator->getUrl());
    }
}