<?php
/**
 * Created by PhpStorm.
 * User: qbik
 * Date: 27.06.2017
 * Time: 14:41
 */

namespace GenesisGlobal\Salesforce\Http\Response;

/**
 * Class ResponseError
 * @package GenesisGlobal\Salesforce\Http\Response
 */
class ResponseError implements ResponseErrorInterface
{
    /** @var  string */
    protected $message;

    /** @var  string */
    protected $code;

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

}