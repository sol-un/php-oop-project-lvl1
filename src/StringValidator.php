<?php

namespace Validator;

use Tightenco\Collect\Support\Collection;
use Validator\Validator;

class StringValidator
{
    private Collection $checks;
    private ?int $minLength;
    private ?string $substring;

    public function __construct()
    {
        $this->checks = collect([function ($value) {
            return in_array(gettype($value), ['string', 'NULL']);
        }]);
        $this->minLength = null;
        $this->substring = null;
    }

    public function required(): StringValidator
    {
        $this->checks->push(function ($value) {
            return strlen($value) > 0;
        });

        return $this;
    }

    public function contains(string $substring): StringValidator
    {
        $prev = $this->substring;
        $this->substring = $substring;

        if (!$prev) {
            $this->checks->push(function ($value) {
                return str_contains($value, $this->substring);
            });
        }

        return $this;
    }

    public function minLength(int $length): StringValidator
    {
        $prev = $this->minLength;
        $this->minLength = $length;

        if (!$prev) {
            $this->checks->push(function ($value) {
                return strlen($value) > $this->minLength;
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
