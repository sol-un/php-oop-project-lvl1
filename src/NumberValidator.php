<?php

namespace Validator;

use Tightenco\Collect\Support\Collection;
use Validator\Validator;

class NumberValidator
{
    private Collection $checks;
    private ?array $range;

    public function __construct()
    {
        $this->checks = collect([function ($value) {
            return in_array(gettype($value), ['integer', 'NULL']);
        }]);
        $this->range = null;
    }

    public function required(): NumberValidator
    {
        $this->checks->push(function ($value) {
            return gettype($value) !== 'NULL';
        });

        return $this;
    }

    public function positive(): NumberValidator
    {
        $this->checks->push(function ($value) {
            return $value > 0 || $value === null;
        });

        return $this;
    }

    public function range(int $min, int $max): NumberValidator
    {
        $prev = $this->range;
        $this->range = [$min, $max];

        if (!$prev) {
            $this->checks->push(function ($value) {
                [$min, $max] = $this->range;
                return $min <= $value && $value <= $max;
            });
        }

        return $this;
    }

    public function isValid($value): bool
    {
        return $this->checks->every(function ($check) use ($value) {
            return $check($value);
        });
    }
}
