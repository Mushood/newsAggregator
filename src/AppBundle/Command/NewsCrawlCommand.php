<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewsCrawlCommand extends ContainerAwareCommand
{
    protected function configure()
    {
      $this
      // the name of the command (the part after "bin/console")
      ->setName('news:crawl')

      // the short description shown while running "php bin/console list"
      ->setDescription('Crawl news')

      // the full command description shown when running the command with
      // the "--help" option
      ->setHelp('This command allows crawls newspaper');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
          'Crawling news websites',
          '============',
          '',
        ]);

        $newsUpdater = $this->getContainer()->get('app.news_updater');

        // On récupère le repository
        $repository = $this->getContainer()->get('doctrine')
          ->getManager()
          ->getRepository('AppBundle:Crawler')
        ;

        $newsCrawlers = $repository->findAll();

        foreach ($newsCrawlers as $key => $newsCrawler) {
            $output->writeln([
              'Starting crawler for "' . $newsCrawler->getCategory()->getName() .'" of newspaper '. $newsCrawler->getNewspaper()->getName(),
            ]);
            $newsUpdater->updateNews($newsCrawler);
        }
    }
}
