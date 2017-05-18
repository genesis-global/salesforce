<?php

namespace GenesisGlobal\Salesforce\Authentication;


/**
 * Interface AuthenticationCallbackInterface
 *
 * If you need to perform some action after failed or succeed authentication,
 * create callback class which implement this interface
 * @package GenesisGlobal\Salesforce\Authentication
 */
interface AuthenticationCallbackInterface
{
    /**
     * @param $request
     */
    public function afterAuthenticationRequest($request);
}