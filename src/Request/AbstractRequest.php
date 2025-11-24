<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request;

use ReflectionClass;
use ReflectionProperty;

/**
 * Abstract base class for all API request classes.
 * @SuppressWarnings("NumberOfChildren")
 */
abstract class AbstractRequest implements RequestInterface
{
    /**
     * Convert the request to an array that can be passed to the API client.
     *
     * This method should be overridden by child classes if they need custom conversion logic.
     * Get all public properties of the class
     * Skip null values
     *
     * @return array The request data as an array
     */
    public function toArray(): array
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

        $data = [];
        foreach ($properties as $property) {
            $name = $property->getName();
            $value = $property->getValue($this);

            if ($value !== null) {
                $snakeName = self::camelToSnake($name);
                $data[$snakeName] = $value;
            }
        }

        return $data;
    }

    /**
     * Helper to convert camelCase → snake_case
     */
    protected static function camelToSnake(string $input): string
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $input));
    }
}
