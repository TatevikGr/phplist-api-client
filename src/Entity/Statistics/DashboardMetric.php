<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity\Statistics;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity class for a dashboard metric card.
 */
class DashboardMetric extends AbstractResponse
{
    /**
     * @var int|float The metric value.
     */
    public int|float $value;

    /**
     * @var float Percentage change against previous month.
     */
    public float $changeVsLastMonth;

    public function __construct(array $data)
    {
        $rawValue = $data['value'] ?? 0;
        $this->value = $this->normalizeValue($rawValue);
        $this->changeVsLastMonth = isset($data['change_vs_last_month']) ? (float)$data['change_vs_last_month'] : 0.0;
    }

    /**
     * Normalize metric value to int or float based on numeric shape.
     *
     * @param mixed $value
     */
    private function normalizeValue(mixed $value): int|float
    {
        if (is_float($value)) {
            return $value;
        }

        if (is_int($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return str_contains((string)$value, '.') ? (float)$value : (int)$value;
        }

        return 0;
    }
}
