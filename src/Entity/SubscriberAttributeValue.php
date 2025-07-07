<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity class for a subscriber attribute value.
 */
class SubscriberAttributeValue extends AbstractResponse
{
    /**
     * @var Subscriber|null The subscriber
     */
    public ?Subscriber $subscriber = null;

    /**
     * @var SubscriberAttributeDefinition|null The attribute definition
     */
    public ?SubscriberAttributeDefinition $definition = null;

    /**
     * @var string|null The value of the attribute
     */
    public ?string $value = null;

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        if ($this->subscriber instanceof Subscriber) {
            $data['subscriber'] = $this->subscriber->toArray();
        }

        if ($this->definition instanceof SubscriberAttributeDefinition) {
            $data['definition'] = $this->definition->toArray();
        }

        return $data;
    }

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if ($key === 'subscriber' && is_array($value)) {
                $this->subscriber = new Subscriber($value);
            } elseif ($key === 'definition' && is_array($value)) {
                $this->definition = new SubscriberAttributeDefinition($value);
            } elseif (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
