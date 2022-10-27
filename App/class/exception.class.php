<?php namespace App\class;

use \Exception as BaseException;

class Exception extends BaseException
{
  public function __construct($e)
  {
    if ($e instanceof BaseException) parent::__construct($e->getMessage());
    elseif (is_string($e)) return $e;
    else parent::__construct();
  }
}