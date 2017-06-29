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
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code)
    {
        $this->code = $code;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @param bool $success
     */
    public function setSuccess(bool $success)
    {
        $this->success = $success;
    }

    /**
     * @return ResponseError[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param ResponseError[] $errors
     */
    public function setErrors(array $errors)
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
     * @return array
     */
    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * @param array $content
     */
    public function setContent(array $content)
    {
        $this->content = $content;
    }

}
