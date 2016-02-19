<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VereinUpdateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:verein:update')
            ->setDescription('Update table Verein')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sync= $this->getContainer()->get("app.util.sync.verein");
        $em = $this->getContainer()->get('doctrine')->getManager('default');
        $sync->getNewDataSets();
        $vereine = $em->getRepository('AppBundle\Entity\VereinExtern')->findAll();
        
        foreach ($vereine as $vereinExtern) {
            $verein = $em->getRepository('AppBundle\Entity\Verein')->findOneByVereinsnummer($vereinExtern->getId());
            if (!$verein){
                $sync->setNewDatasets($vereinExtern);
                $output->writeln("Verein hinzugefügt: ".$vereinExtern->getName());
            } else {
                $sync->setNewDatasets($vereinExtern, $verein);
            }
        }
        
        $em->flush();
        $output->writeln("Fertig");
    }
}