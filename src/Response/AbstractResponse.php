<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response;

use ReflectionClass;
use ReflectionProperty;

/**
 * Abstract base class for all API response classes.
 */
abstract class AbstractResponse implements ResponseInterface
{
    /**
     * Create a response object from an array of data returned by the API.
     *
     * This method should be overridden by child classes if they need custom conversion logic.
     *
     * @param array $data The response data as an array
     * @return static The response object
     */
    public static function fromArray(array $data): self
    {
        $instance = new static();
        
        // Set all public properties from the data array
        foreach ($data as $key => $value) {
            if (property_exists($instance, $key)) {
                $instance->$key = $value;
            }
        }
        
        return $instance;
    }

    /**
     * Convert the response to an array.
     *
     * This method should be overridden by child classes if they need custom conversion logic.
     *
     * @return array The response data as an array
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
            
            // Include all values, even null ones
            $data[$name] = $value;
        }
        
        return $data;
    }
}
