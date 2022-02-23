<?php

namespace Validator\Tests;

use PHPUnit\Framework\TestCase;
use Validator\Validator;

class ValidatorTest extends TestCase
{
    public function testString(): void
    {
        $v = new Validator();

        $schema = $v->string();
        $schema2 = $v->string();

        $this->assertTrue($schema->isValid(''));
        $this->assertTrue($schema->isValid(null));
        $this->assertFalse($schema->isValid(10));

        $schema->required();
        $this->assertTrue($schema->isValid('test'));
        $this->assertFalse($schema->isValid(null));
        $this->assertFalse($schema->isValid(''));
        $this->assertFalse($schema->isValid(0));

        $this->assertTrue($schema->minLength(10)->minLength(5)->isValid('Hexlet'));

        $this->assertTrue($schema2->isValid(''));
        $this->assertTrue($schema2->isValid(null));
        $this->assertFalse($schema2->isValid(0));
        $this->assertTrue($schema2->contains('what')->isValid('what does the fox say'));
        $this->assertFalse($schema2->contains('whatthe')->isValid('what does the fox say'));
    }
}
