<?php

namespace Zer0\Throttle\Providers;

use Zer0\App;
use Zer0\Cache\Item\Item;
use Zer0\Config\Interfaces\ConfigInterface;
use Zer0\Cache\Exceptions\QueryFailedException;
use Zer0\Throttle\Result;

/**
 * Class ExtRedis
 *
 * @package Zer0\Throttle\Providers
 */
final class ExtRedis extends Base
{
    /**
     * @var \Redis
     */
    protected $redis;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * ExtRedis constructor.
     *
     * @param ConfigInterface $config
     * @param App $app
     */
    public function __construct(ConfigInterface $config, App $app)
    {
        parent::__construct($config, $app);
        $this->redis = $this->app->broker('ExtRedis')->get($config->redis ?? '');
        $this->prefix = $config->prefix ?? 'throttle:';
    }

    /** @inheritDoc */
    public function throttle(string $key, int $max_burst, int $count_per_period, int $period, int $quantity = 1)
    {
        $res = $this->redis->rawCommand('CF.THROTTLE', $key, $max_burst, $count_per_period, $period, $quantity);

        return new Result($res[0] === 0, $res[1], $res[2], $res[3], $res[4]);
    }
}
