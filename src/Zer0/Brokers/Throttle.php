<?php

namespace Zer0\Brokers;

use PHPDaemon\Core\ClassFinder;
use Zer0\Config\Interfaces\ConfigInterface;

/**
 * Class Throttle
 *
 * @package Zer0\Brokers
 */
class Throttle extends Base
{
    /**
     * @param ConfigInterface $config
     * @return object
     */
    public function instantiate(ConfigInterface $config)
    {
        $class = ClassFinder::find($config->type ?? 'ExtRedis', ClassFinder::getNamespace(\Zer0\Throttle\Providers\Base::class), '~');

        return new $class($config, $this->app);
    }

    /**
     * @param string $name
     * @param bool $caching
     * @return  \Zer0\Throttle\Providers\Base
     */
    public function get(string $name = '', bool $caching = true): \Zer0\Throttle\Providers\Base
    {
        return parent::get($name, $caching);
    }
}
