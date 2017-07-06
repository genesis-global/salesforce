<?php
/**
 * Created by PhpStorm.
 * User: qbik
 * Date: 06.07.2017
 * Time: 14:22
 */

namespace GenesisGlobal\Salesforce\Tests\Authentication;


use GenesisGlobal\Salesforce\Authentication\Exception\AuthenticationException;
use GenesisGlobal\Salesforce\Authentication\SalesforceAuthenticationCallback;


class SalesforceAuthenticationCallbackTest extends \PHPUnit\Framework\TestCase
{
    public function testAfterAuthenticationRequest()
    {
        $response = new \stdClass();
        $response->code = 400;
        $callback = new SalesforceAuthenticationCallback();
        try {
            $callback->afterAuthenticationRequest($response);
        } catch (\Exception $e) {
            $this->assertInstanceOf(AuthenticationException::class, $e);
            $this->assertEquals('Could not authenticate Salesforce user.', $e->getMessage());
        }
    }
}