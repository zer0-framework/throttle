<?php

namespace Zer0\Throttle;

/**
 *
 */
class Result
{
    /**
     * @var bool
     */
    private $allowed;

    /**
     * @var int
     */
    private $totalLimit;

    /**
     * @var int
     */
    private $remainingLimit;

    /**
     * @var int
     */
    private $retryAfter;

    /**
     * @var int
     */
    private $resetAfter;

    /**
     * @param bool $allowed
     * @param int $totalLimit
     * @param int $remainingLimit
     * @param int $retryAfter
     * @param int $resetAfter
     */
    public function __construct(bool $allowed, int $totalLimit, int $remainingLimit, int $retryAfter, int $resetAfter)
    {
        $this->allowed = $allowed;
        $this->totalLimit = $totalLimit;
        $this->remainingLimit = $remainingLimit;
        $this->retryAfter = $retryAfter;
        $this->resetAfter = $resetAfter;
    }

    /**
     * @return bool
     */
    public function isAllowed(): bool
    {
        return $this->allowed;
    }

    /**
     * @return int
     */
    public function totalLimit(): int
    {
        return $this->totalLimit;
    }

    /**
     * @return int
     */
    public function remainingLimit(): int
    {
        return $this->remainingLimit;
    }

    /**
     * @return int
     */
    public function retryAfter(): int
    {
        return $this->retryAfter;
    }

    /**
     * @return int
     */
    public function resetAfter(): int
    {
        return $this->resetAfter;
    }
}