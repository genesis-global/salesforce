<?php
/**
 * Created by PhpStorm.
 * User: qbik
 * Date: 27.06.2017
 * Time: 14:19
 */

namespace GenesisGlobal\Salesforce\Http\Response;

/**
 * Class Response
 * @package GenesisGlobal\Salesforce\Http\Response
 */
class Response implements ResponseInterface
{
    /** @var  boolean */
    protected $success;

    /** @var  ResponseError[] */
    protected $errors;

    /** @var  array */
    protected $content;

    /** @var  int */
    protected $code;

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @param bool $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }

    /**
     * @return ResponseError[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param ResponseError[] $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * @param ResponseError $error
     * @return array|ResponseError[]
     */
    public function addError(ResponseError $error)
    {
        $this->errors[] = $error;
        return $this->errors;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

}
