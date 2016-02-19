<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SpielerUpdateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:spieler:update')
            ->setDescription('Update table Spieler')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sync= $this->getContainer()->get("app.util.sync.spieler");
        $em = $this->getContainer()->get('doctrine')->getManager('default');
        $sync->getNewDataSets();
        $spielers = $em->getRepository('AppBundle\Entity\SpielerExtern')->findAll();
        
        foreach ($spielers as $spielerExtern) {
            $spieler = $em->getRepository('AppBundle\Entity\Spieler')->findOneBySpielerExtern($spielerExtern);
            if ($spieler === null){
                $sync->setNewDatasets($spielerExtern);
                $output->writeln("Spieler hinzugefügt: ".$spielerExtern->getVorname()." ".$spielerExtern->getNachname());
            } else {
                $sync->setNewDatasets($spielerExtern, $spieler);
                $output->writeln("Spieler update: ".$spielerExtern->getVorname()." ".$spielerExtern->getNachname());
            }
        }
        
        $em->flush();
        $output->writeln("Fertig");
    }
}