<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use DateTimeImmutable;
use Exception;
use PhpList\RestApiClient\Response\AbstractResponse;

class Subscription extends AbstractResponse
{
    public Subscriber $subscriber;
    public SubscriberList $subscriberList;
    public DateTimeImmutable $subscriptionDate;

    /**
     * @throws Exception
     */
    public function __construct(array $data)
    {
        $this->subscriber = new Subscriber($data['subscriber']);
        $this->subscriberList = new SubscriberList($data['subscriber_list']);
        $this->subscriptionDate = new DateTimeImmutable($data['subscription_date']);
    }
}
