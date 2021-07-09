<?php

declare(strict_types=1);

namespace Kraber\Test;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Get the value of an object property.
     *
     * @param object $object
     * @param string $property Property name.
     *
     * @return mixed Property value.
     * @throws InvalidArgumentException If no property exists by that name.
     */
    public function getPropertyValue(object $object, string $property): mixed
    {
        $reflectionClass = new ReflectionClass($object);
        try {
            $prop = $reflectionClass->getProperty($property);
        } catch (ReflectionException) {
            throw new InvalidArgumentException(
                "Invalid property name '" . $property . "' provided. Property must exists on the provided object."
            );
        }

        if ($prop->isProtected() || $prop->isPrivate()) {
            $prop->setAccessible(true);
        }

        $value = $prop->getValue($prop->isStatic() ? null : $object);

        if ($prop->isProtected() || $prop->isPrivate()) {
            $prop->setAccessible(false);
        }

        return $value;
    }

    /**
     * Set the value of an object property.
     *
     * @param object $object
     * @param string $property Property name.
     * @param mixed $value Property value.
     *
     * @throws InvalidArgumentException If no property exists by that name.
     */
    public function setPropertyValue(object $object, string $property, mixed $value): void
    {
        $reflectionClass = new ReflectionClass($object);
        try {
            $prop = $reflectionClass->getProperty($property);
        } catch (ReflectionException) {
            throw new InvalidArgumentException(
                "Invalid property name '" . $property . "' provided. Property must exists on the provided object."
            );
        }

        if ($prop->isProtected() || $prop->isPrivate()) {
            $prop->setAccessible(true);
        }

        $prop->setValue($prop->isStatic() ? null : $object, $value);

        if ($prop->isProtected() || $prop->isPrivate()) {
            $prop->setAccessible(false);
        }
    }
}
