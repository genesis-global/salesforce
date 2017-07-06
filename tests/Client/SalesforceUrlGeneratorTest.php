<?php
/**
 * Created by PhpStorm.
 * User: qbik
 * Date: 06.07.2017
 * Time: 16:35
 */

namespace GenesisGlobal\Salesforce\Tests\Client;


use GenesisGlobal\Salesforce\Client\SalesforceUrlGenerator;
use PHPUnit\Framework\TestCase;

class SalesforceUrlGeneratorTest extends TestCase
{
    public function testGetUrl()
    {
        $endpoint = 'http://test-point.com';
        $version = '2.0';

        $urlGenerator = new SalesforceUrlGenerator($endpoint, $version);

        $this->assertEquals('http://test-point.com/services/data/2.0/', $urlGenerator->getUrl());
        $this->assertEquals(
            'http://test-point.com/services/data/2.0/sobjects',
            $urlGenerator->getUrl('sobjects')
        );
        $this->assertEquals(
            'http://test-point.com/services/data/2.0/sobjects?externalId=123123',
            $urlGenerator->getUrl('sobjects', [ 'externalId' => '123123'])
        );
    }
}