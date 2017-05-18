<?php

namespace GenesisGlobal\Salesforce\Authentication;


use GenesisGlobal\Salesforce\Authentication\Exception\AuthenticationException;

/**
 * Class SalesforceAuthenticationCallback
 * @package GenesisGlobal\Salesforce\Authentication
 */
class SalesforceAuthenticationCallback implements AuthenticationCallbackInterface
{
    /**
     * @param $response
     * @throws AuthenticationException
     */
    public function afterAuthenticationRequest($response)
    {
        if ($response->code !== 200 || !isset($response->body->access_token)) {
            throw new AuthenticationException('Could not authenticate Salesforce user.', $response->code);
        }
    }
}