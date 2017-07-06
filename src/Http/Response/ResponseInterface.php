<?php

namespace GenesisGlobal\Salesforce\Http\Response;

/**
 * Created by PhpStorm.
 * User: qbik
 * Date: 27.06.2017
 * Time: 14:18
 */
interface ResponseInterface
{
    /**
     * @return boolean
     */
    public function isSuccess();

    /**
     * @param bool $success
     */
    public function setSuccess($success);

    /**
     * @return ResponseError[]
     */
    public function getErrors();

    /**
     * @param ResponseError[] $errors
     */
    public function setErrors($errors);

    /**
     * @param ResponseError $error
     * @return array|ResponseError[]
     */
    public function addError(ResponseError $error);

    /**
     * @return mixed
     */
    public function getContent();

    /**
     * @param $content
     */
    public function setContent($content);
}
