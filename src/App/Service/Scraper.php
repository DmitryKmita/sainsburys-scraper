<?php

namespace App\Service;
use App\Config\Config;
use App\Helper\HtmlHelper;
use App\Model\Product;
use App\Model\Result;
use Buzz\Browser;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class Scraper
 * @package App\Service
 */
class Scraper
{
    /**
     * @var Browser
     */
    private $buzzBrowser;

    /**
     * @var Config
     */
    private $config;

    /**
     * Is verbose?
     *
     * @var boolean
     */
    private $verbose;

    /**
     * @return Browser
     */
    public function getBuzzBrowser()
    {
        return $this->buzzBrowser;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param Config $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @param Browser $buzzBrowser
     */
    public function setBuzzBrowser($buzzBrowser)
    {
        $this->buzzBrowser = $buzzBrowser;
    }

    /**
     * @return boolean
     */
    public function isVerbose()
    {
        return $this->verbose;
    }

    /**
     * @param boolean $verbose
     */
    public function setVerbose($verbose)
    {
        $this->verbose = $verbose;
    }

    /**
     * Scrapes data and outputs it
     *
     * @param OutputInterface $output
     */
    public function startScraping(OutputInterface $output)
    {
        $host = $this->config->getConfig('host');
        $response = $this->buzzBrowser->get($host);
        $html = $response->getContent();
        $crawler = new Crawler($html);
        $items = $crawler->filter('.productLister .product ')->each(function(Crawler $node) use($output) {
            $item = new Product();
            $item->setTitle($this->processTitle($node->filter('.productInfo h3 a')->html()));
            $item->setUnitPrice($this->processUnitPrice($node->filter('.pricePerUnit')->html()));

            $response = $this->buzzBrowser->get($node->filter('.productInfo h3 a')->attr('href'));
            $item->setSize(round($response->getHeader('Content-Length') / 1024, 2));

            $crawler = new Crawler($response->getContent());
            $item->setDescription($crawler->filter('meta[name="description"]')->attr('content'));
            if ($this->verbose) {
                $output->writeln("[>] Item {$item->getTitle()} processed");
            }
            return $item;
        });
        $output->writeln($this->processResult($items));
    }

    /**
     * Build result set of data for result
     *
     * @param Product[] $items
     * @return string
     */
    private function processResult($items)
    {
        $result = new Result();
        $result->setItems($items);
        return json_encode($result->toArray());
    }

    /**
     * Processes html and gets the unit price, also converts to float
     *
     * @param $html
     * @return float
     */
    private function processUnitPrice($html)
    {
        return number_format(
            (float) str_replace(
                '&pound',
                '',
                trim(
                    htmlspecialchars_decode(
                        strpos($html, '<') > 0 ? substr($html, 0, strpos($html, '<')) : $html
                    )
                )
            ),
            2
        );
    }

    /**
     * Gets Proper Title from HTML
     *
     * @param $html
     * @return string
     */
    private function processTitle($html)
    {
        return trim(
            htmlspecialchars_decode(
                HtmlHelper::removeImageTagFromString($html)
            )
        );
    }
}