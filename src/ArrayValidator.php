<?php

namespace Validator;

use Tightenco\Collect\Support\Collection;
use Validator\Validator;

class ArrayValidator
{
    private Collection $checks;
    private ?int $sizeof;
    private ?array $shape;

    public function __construct()
    {
        $this->checks = collect([function ($value) {
            return in_array(gettype($value), ['array', 'NULL']);
        }]);
        $this->sizeof = null;
        $this->shape = null;
    }

    public function required(): ArrayValidator
    {
        $this->checks->push(function ($value) {
            return gettype($value) === 'array';
        });

        return $this;
    }
    
    public function sizeof(int $size): ArrayValidator
    {
        $prev = $this->sizeof;
        $this->sizeof = $size;
        
        if (!$prev) {
            $this->checks->push(function ($value) {
                return count($value) >= $this->sizeof;
            });
        }
        
        return $this;
    }
    
    public function shape(array $shape): ArrayValidator
    {
        $this->shape = $shape;
        $this->checks->push(function ($array) {
            return collect($array)
                ->map(function ($value, $key) {
                    return $this->shape[$key]->isValid($value);
                })
                ->every(function ($value) {
                    return $value;
                });
        });
    
        return $this;
    }

    public function isValid($value): bool
    {
        return $this->checks->every(function ($check) use ($value) {
            return $check($value);
        });
    }
}
