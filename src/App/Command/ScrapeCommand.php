<?php

namespace App\Command;

use App\Service\ScraperFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScrapeCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:scrape')
            ->setDescription('Crapes data from page and returns JSON with data')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $verbose = $input->getOption('verbose');
        if ($verbose) {
            $output->writeln('Scraper is started');
        }
        $factory = new ScraperFactory();
        $service = $factory->init();
        $service->setVerbose($verbose);
        $service->startScraping($output);
        if ($verbose) {
            $output->writeln('Scraper is finished');
        }
    }
}