<?php

namespace App\Model;

class BaseModel extends \App\Libraries\PdoModel
{
    protected $connection = "pdo.opos";
}