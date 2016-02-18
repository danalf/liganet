<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SpielerSetNewCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:spieler:setnew')
            ->setDescription('Set new spieler to table Spieler')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sync= $this->getContainer()->get("app.util.sync.spieler");
        $em = $this->getContainer()->get('doctrine')->getManager('default');
        $spielers = $em->getRepository('AppBundle\Entity\SpielerExtern')->findAll();
        
        foreach ($spielers as $spieler) {
            if ($spieler->getSpieler() === null){
                $sync->setNewDatasets($spieler);
                $output->writeln("Spieler hinzugefügt: ".$spieler->getVorname()." ".$spieler->getNachname());
            }
        }
        
        $em->flush();
        $output->writeln("Fertig");
    }
}