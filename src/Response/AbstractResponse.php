<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response;

use ReflectionClass;
use ReflectionProperty;

/**
 * Abstract base class for all API response classes.
 * @SuppressWarnings("NumberOfChildren")
 */
abstract class AbstractResponse implements ResponseInterface
{
    /**
     * Convert the response to an array.
     *
     * This method should be overridden by child classes if they need custom conversion logic.
     * Get all public properties of the class
     * Include all values, even null ones
     *
     * @return array The response data as an array
     */
    public function toArray(): array
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
        
        $data = [];
        foreach ($properties as $property) {
            $name = $property->getName();
            $value = $property->getValue($this);

            $snakeName = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $name));
            $data[$snakeName] = $value;        }
        
        return $data;
    }
}
