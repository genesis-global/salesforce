<?php
/**
 * Created by PhpStorm.
 * User: qbik
 * Date: 06.07.2017
 * Time: 16:19
 */

namespace GenesisGlobal\Salesforce\Tests\Client;



use GenesisGlobal\Salesforce\Client\SalesforceClient;
use GenesisGlobal\Salesforce\Client\SalesforceClientFactory;
use PHPUnit\Framework\TestCase;

class SalesforceClientFactoryTest extends TestCase
{
    public function testCreate()
    {
        $config = [
            'authentication' => [
                'endpoint' => 'http://endpoint',
                'client_id' => 'id',
                'client_secret' => 'secret',
                'username' => 'name',
                'password' => 'pass',
                'security_token' => 'cs-0ds-s0dfsd'
            ],
            'rest' => [
                'version' => '2.0',
                'endpoint' => 'http://endpoint'
            ]
        ];
        $factory = new SalesforceClientFactory();
        $this->assertInstanceOf(SalesforceClient::class, $factory->create($config));
    }
}