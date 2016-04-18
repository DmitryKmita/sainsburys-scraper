<?php

namespace App\Config;

class Config
{
    private static $configs = [
        'host' => 'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html'
    ];

    /**
     * @return array
     */
    public function getConfigs()
    {
        return self::$configs;
    }

    /**
     * @param $key
     * @return bool
     */
    public function getConfig($key)
    {
        return isset(self::$configs[$key]) ? self::$configs[$key] : false;
    }
}