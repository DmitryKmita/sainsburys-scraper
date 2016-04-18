<?php

namespace App\Service;
use App\Config\Config;
use Buzz\Browser;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class ScraperFactory
 * @package App\Service
 */
class ScraperFactory
{
    /**
     * Scraper Factory
     *
     * @return Scraper
     */
    public function init()
    {
        $service = new Scraper();
        $service->setBuzzBrowser(new Browser());
        $service->setConfig(new Config());
        return $service;
    }
}