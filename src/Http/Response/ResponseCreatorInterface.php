<?php
/**
 * Created by PhpStorm.
 * User: qbik
 * Date: 27.06.2017
 * Time: 14:22
 */

namespace GenesisGlobal\Salesforce\Http\Response;

/**
 * Interface ResponseCreatorInterface
 * @package GenesisGlobal\Salesforce\Http\Response
 */
interface ResponseCreatorInterface
{
    /**
     * @param $httpResponse
     * @return ResponseInterface
     */
    public function create($httpResponse);
}