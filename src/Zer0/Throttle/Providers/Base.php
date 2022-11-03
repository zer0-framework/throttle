<?php

namespace Zer0\Throttle\Providers;

use Zer0\App;
use Zer0\Cache\Item\Item;
use Zer0\Cache\Traits\Hash;
use Zer0\Cache\Traits\Serialization;
use Zer0\Config\Interfaces\ConfigInterface;
use Zer0\Cache\Exceptions\QueryFailedException;

/**
 * Class Base
 *
 * @package Zer0\Throttle\Providers
 */
abstract class Base
{
    use Hash;

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var App
     */
    protected $app;

    /**
     * Base constructor.
     *
     * @param ConfigInterface $config
     * @param App $app
     */
    public function __construct(ConfigInterface $config, App $app)
    {
        $this->config = $config;
        $this->app = $app;
    }

    /**
     * @param string $key
     * @param null $hasValue
     *
     * @throws QueryFailedException
     * @return mixed|null
     */
    abstract public function throttle(
        string $key,
        int $max_burst,
        int $count_per_period,
        int $period,
        int $quantity = 1
    );
}