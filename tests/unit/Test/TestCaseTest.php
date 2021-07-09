<?php

declare(strict_types=1);

namespace Kraber\Test\Unit\Test;

use Kraber\Test\TestCase;
use InvalidArgumentException;

class TestCaseTest extends TestCase
{
    public function testGetPrivatePropertyValue(): void
    {
        $obj = new class () {
            public function __construct(private int $prop = 42)
            {
            }
        };

        $this->assertEquals(42, $this->getPropertyValue($obj, 'prop'));
    }

    public function testGetPrivatePropertyValueThrowsExceptionWithNonExistingPropertyName(): void
    {
        $obj = new class () {
            public function __construct(private int $prop = 42)
            {
            }
        };

        $this->expectException(InvalidArgumentException::class);
        $this->getPropertyValue($obj, 'invalidProp');
    }

    public function testSetPrivatePropertyValue(): void
    {
        $obj = new class () {
            public function __construct(private int $prop = 42)
            {
            }

            public function getPropertyValue(): int
            {
                return $this->prop;
            }
        };

        $this->assertEquals(42, $obj->getPropertyValue());
        $this->setPropertyValue($obj, 'prop', 84);
        $this->assertEquals(84, $obj->getPropertyValue());
    }

    public function testSetPrivatePropertyValueThrowsExceptionWithNonExistingPropertyName(): void
    {
        $obj = new class () {
            public function __construct(private int $prop = 42)
            {
            }

            public function getPropertyValue(): int
            {
                return $this->prop;
            }
        };

        $this->expectException(InvalidArgumentException::class);
        $this->setPropertyValue($obj, 'invalidProp', 84);
    }
}
