<?php

namespace Validator;

use Tightenco\Collect\Support\Collection;
use Validator\StringValidator;

class Validator
{
    public function string(): StringValidator
    {
        return new StringValidator();
    }
}
