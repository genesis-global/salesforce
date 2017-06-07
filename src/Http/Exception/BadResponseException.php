<?php


namespace GenesisGlobal\Salesforce\Http\Exception;

/**
 * Class BadResponseException
 * @package GenesisGlobal\Salesforce\Http\Exception
 */
class BadResponseException extends \Exception
{
    /**
     * @var mixed
     */
    protected $response;

    /**
     * BadResponseException constructor.
     * @param string $message
     * @param int $code
     * @param null $previous
     * @param mixed $response
     */
    public function __construct($message = "", $code = 0, $previous = null, $response = null)
    {
        $this->response = $response;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }
}
