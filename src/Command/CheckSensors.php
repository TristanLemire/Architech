<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;

class CheckSensors extends Command
{
// the name of the command (the part after "bin/console")
protected static $defaultName = 'app:checkSensors';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

protected function configure(): void
{
// ...
}

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        echo "coucou";
    }
}