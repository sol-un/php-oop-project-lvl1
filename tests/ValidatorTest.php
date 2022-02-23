<?php

namespace Validator\Tests;

use PHPUnit\Framework\TestCase;
use Validator\Validator;

class ValidatorTest extends TestCase
{
    public function testString(): void
    {
        $validator = new Validator();
        $validator->string();
        $this->assertTrue($validator->isValid(''));
        $this->assertFalse($validator->isValid(0));
    }
}
