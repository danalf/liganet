<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VereinSetNewCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:verein:setnew')
            ->setDescription('Set new vereine to table Verein')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sync= $this->getContainer()->get("app.util.sync.verein");
        $em = $this->getContainer()->get('doctrine')->getManager('default');
        $vereine = $em->getRepository('AppBundle\Entity\VereinExtern')->findAll();
        
        foreach ($vereine as $vereinExtern) {
            $verein = $em->getRepository('AppBundle\Entity\Verein')->findOneByVereinsnummer($vereinExtern->getId());
            if (!$verein){
                $sync->setNewDatasets($vereinExtern);
                $output->writeln("Verein hinzugefügt: ".$vereinExtern->getName());
            }
        }
        
        $em->flush();
        $output->writeln("Fertig");
    }
}