#!/usr/bin/env php
<?php
    require __DIR__ . '/vendor/autoload.php';

    use Symfony\Component\Console\Application;
    use App\Command\ScrapeCommand;

    $application = new Application();
    $application->add(new ScrapeCommand());
    $application->run();