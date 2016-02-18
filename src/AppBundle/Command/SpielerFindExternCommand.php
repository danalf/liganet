<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SpielerFindExternCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:spieler:findextern')
            ->setDescription('Find spieler to set spielerExtern-id')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager('default');
        $spielers = $em->getRepository('AppBundle\Entity\SpielerExtern')->findAll();
        $i=0;
        foreach ($spielers as $spielerExtern) {
            echo $i++."\n";
            $output->writeln("Spieler gesucht: ".$spielerExtern->getLizenznummer()." ".$spielerExtern->getVorname()." ".$spielerExtern->getNachname());
            $spieler = $em->getRepository('AppBundle\Entity\Spieler')->findOneByLizenznummerAndName(
                    $spielerExtern->getLizenznummer(), $spielerExtern->getVorname(),$spielerExtern->getNachname());
            if ($spieler){
                $spieler->setSpielerExtern($spielerExtern);
                $spieler->setVeraendertAm(new \DateTime());
                $em->persist($spieler);
                $output->writeln("Spieler gefunden: ".$spieler);
            } else {
                $output->writeln("Spieler nicht in Spielertabelle: ".$spielerExtern->getLizenznummer()." ".$spielerExtern->getVorname()." ".$spielerExtern->getNachname());
            }
            if ($i % 100 == 0 ){
                $em->flush();
            }
        }
        
        $spielerNotFound = $em->getRepository('AppBundle\Entity\Spieler')->findBy(['spielerExtern' => null]);
        foreach ($spielerNotFound as $spieler) {
            $output->writeln("Spieler nicht gefunden: ".$spieler->getVorname()." ".$spieler->getNachname());
        }

        $em->flush();
        $output->writeln("Fertig");
    }
}