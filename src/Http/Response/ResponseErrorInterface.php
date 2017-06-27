<?php
/**
 * Created by PhpStorm.
 * User: qbik
 * Date: 27.06.2017
 * Time: 14:40
 */

namespace GenesisGlobal\Salesforce\Http\Response;

/**
 * Interface ResponseErrorInterface
 * @package GenesisGlobal\Salesforce\Http\Response
 */
interface ResponseErrorInterface
{
    /**
     * @return string
     */
    public function getCode();

    /**
     * @return string
     */
    public function getMessage();
}
