<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request;

use ReflectionClass;
use ReflectionProperty;

/**
 * Abstract base class for all API request classes.
 */
abstract class AbstractRequest implements RequestInterface
{
    /**
     * Convert the request to an array that can be passed to the API client.
     *
     * This method should be overridden by child classes if they need custom conversion logic.
     *
     * @return array The request data as an array
     */
    public function toArray(): array
    {
        // Get all public properties of the class
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
        
        $data = [];
        foreach ($properties as $property) {
            $name = $property->getName();
            $value = $property->getValue($this);
            
            // Skip null values
            if ($value !== null) {
                $data[$name] = $value;
            }
        }
        
        return $data;
    }
}
