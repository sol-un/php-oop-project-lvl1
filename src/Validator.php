<?php

namespace Validator;

use Tightenco\Collect\Support\Collection;
use Validator\StringValidator;
use Validator\NumberValidator;

class Validator
{
    public function string(): StringValidator
    {
        return new StringValidator();
    }

    public function number(): NumberValidator
    {
        return new NumberValidator();
    }
}
