<?php

namespace Validator;

use Tightenco\Collect\Support\Collection;
use Validator\StringValidator;
use Validator\NumberValidator;
use Validator\ArrayValidator;

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

    public function array(): ArrayValidator
    {
        return new ArrayValidator();
    }
}
