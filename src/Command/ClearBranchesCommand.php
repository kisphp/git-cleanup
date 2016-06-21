<?php

namespace Kisphp\Command;

use Cilex\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearBranchesCommand extends Command
{
    protected function configure()
    {
        $this->setName('clean:branches')
            ->setDescription('Remove merged branches')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('hello world, remove branches');
    }
}
