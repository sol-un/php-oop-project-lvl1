<?php

namespace Validator;

use Tightenco\Collect\Support\Collection;

class Validator
{
    private Collection $checks;

    public function __construct()
    {
        $this->checks = collect([]);
    }

    public function string(): Validator
    {
        $this->checks->push(function ($value) {
            return gettype($value) === 'string';
        });
        
        return $this;
    }

    public function isValid($value): Bool
    {
        return $this->checks->every(function ($check) use ($value) {
            return $check($value);
        });
    }
}
