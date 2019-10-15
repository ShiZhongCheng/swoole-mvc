<?php

namespace Exceptions;

use Exception;

class ApiException extends Exception
{
    protected $code = -1;
    protected $msg = "";
    protected $data = [];

    public function __construct($message = "", $code = 0, $data = [], Throwable $previous = null)
    {
        $this->data = $data;
        parent::__construct($message, $code, $previous);
    }

    public function getData()
    {
        return $this->data;
    }
}