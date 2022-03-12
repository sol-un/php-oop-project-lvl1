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
        $this->assertTrue($schema->isValid(''));
        $this->assertTrue($schema->isValid(null));
        $this->assertFalse($schema->isValid(0));
        $schema->required();
        $this->assertTrue($schema->isValid('Hexlet'));
        $this->assertTrue($schema->minLength(0)->minLength(5)->isValid('Hexlet'));
        $this->assertFalse($schema->isValid(null));
        $this->assertFalse($schema->isValid(''));
        $this->assertFalse($schema->isValid(0));

        $schema2 = $v->string();
        $this->assertTrue($schema2->isValid(''));
        $this->assertTrue($schema2->isValid(null));
        $this->assertFalse($schema2->isValid(0));
        $this->assertTrue($schema2->contains('what')->isValid('what does the fox say'));
        $this->assertFalse($schema2->contains('whatthe')->isValid('what does the fox say'));
    }

    public function testNumber(): void
    {
        $v = new Validator();

        $schema = $v->number();
        $this->assertTrue($schema->isValid(null));
        $schema->required();
        $this->assertFalse($schema->isValid(null));
        $this->assertTrue($schema->isValid(0));
        $this->assertTrue($schema->positive()->isValid(10));
        $this->assertFalse($schema->positive()->isValid(-5));

        $schema2 = $v->number();
        $schema2->range(-5, 5);
        $this->assertTrue($schema->isValid(5));
        $this->assertFalse($schema->isValid(-3));
    }

    public function testArray(): void
    {
        $v = new Validator();

        $schema = $v->array();
        $this->assertTrue($schema->isValid(null));
        
        $schema->required();
        $this->assertTrue($schema->isValid([]));
        $this->assertTrue($schema->isValid(['hexlet']));
        $this->assertFalse($schema->isValid(null));
        $this->assertFalse($schema->isValid(0));
        
        $schema->sizeof(2);
        $this->assertFalse($schema->isValid(['hexlet']));
        $this->assertTrue($schema->isValid(['hexlet', 'code-basics']));

        $schema->shape([
            'name' => $v->string()->required(),
            'age' => $v->number()->positive(),
        ]);
        
         $this->assertTrue($schema->isValid(['name' => 'kolya', 'age' => 100]));
         $this->assertTrue($schema->isValid(['name' => 'maya', 'age' => null]));
         $this->assertFalse($schema->isValid(['name' => '', 'age' => null]));
         $this->assertFalse($schema->isValid(['name' => 'ada', 'age' => -5]));
    }
}
