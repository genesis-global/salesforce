<?php

namespace GenesisGlobal\Salesforce\Authentication;


/**
 * Interface AuthenticatorInterface
 * @package GenesisGlobal\Salesforce\Authentication
 */
interface AuthenticatorInterface
{
    /**
     * @return string
     */
    public function getAccessToken();

    /**
     * Refresh token, just clear property in object, you need to call getAccessToken to get new one.
     */
    public function refreshToken();
}
