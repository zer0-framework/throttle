<?php

namespace Zer0\Throttle\Providers;

use RedisClient\Exception\EmptyResponseException;
use RedisClient\Exception\InvalidArgumentException;
use RedisClient\Pipeline\PipelineInterface;
use RedisClient\RedisClient;
use Zer0\App;
use Zer0\Cache\Item\Item;
use Zer0\Config\Interfaces\ConfigInterface;
use Zer0\Cache\Exceptions\QueryFailedException;
use Zer0\Throttle\Result;

/**
 * Class Redis
 *
 * @package Zer0\Throttle\Providers
 */
final class Redis extends Base
{
    /**
     * @var RedisClient
     */
    protected $redis;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var string
     */
    protected $tagPrefix;

    /**
     * @var bool
     */
    protected $saving = false;

    /**
     * Redis constructor.
     *
     * @param ConfigInterface $config
     * @param App $app
     */
    public function __construct(ConfigInterface $config, App $app)
    {
        parent::__construct($config, $app);
        $this->redis = $this->app->broker('Redis')->get($config->redis ?? '');
        $this->prefix = $config->prefix ?? 'throttle:';
    }

    /** @inheritDoc */
    public function throttle(string $key, int $max_burst, int $count_per_period, int $period, int $quantity = 1)
    {
        $prefixedKey = $this->prefix . $key;
        [, $id] = $this->redis->pipeline(function (PipelineInterface $redis) use ($prefixedKey) {
            $redis->setnx($prefixedKey, base64_encode(microtime()));
            $redis->get($prefixedKey);
        });
        $res = $this->redis->executeRaw(
            ['CL.THROTTLE', $prefixedKey . ':' . $id, $max_burst, $count_per_period, $period, $quantity]
        );

        return new Result($res[0] === 0, $res[1], $res[2], $res[3], $res[4]);
    }

    /** @inheritDoc */
    public function reset($key)
    {
        $this->redis->del($this->prefix . $key);
    }
}
