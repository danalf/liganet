<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VereinFindExternCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:verein:findextern')
            ->setDescription('Find verein to set vereinExtern-id')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //$sync= $this->getContainer()->get("app.util.sync.verein");
        $em = $this->getContainer()->get('doctrine')->getManager('default');
        $vereine = $em->getRepository('AppBundle\Entity\VereinExtern')->findAll();
        
        foreach ($vereine as $vereinExtern) {
            $verein = $em->getRepository('AppBundle\Entity\Verein')->findOneByVereinsnummer($vereinExtern->getId());
            if ($verein){
                $verein->setVereinExtern($vereinExtern);
                $region = $em->getRepository('AppBundle\Entity\Region')->findOneBy(['ligabezirkID' => $vereinExtern->getLigaBezirkID()] );
                if (!$region){
                    throw new Exception("Region nicht über ligaBezirkId gefunden");
                }
                $verein->setRegion($region);
                $em->persist($verein);
            } else {
                $output->writeln("Verein nicht in Vereinstabelle: ".$vereinExtern->getId()." ".$vereinExtern->getName());
            }
        }
        
        $vereineNotFound = $em->getRepository('AppBundle\Entity\Verein')->findBy(['vereinExtern' => null]);
        foreach ($vereineNotFound as $verein) {
            $output->writeln("Verein nicht gefunden: ".$verein->getName());
        }

        $em->flush();
        $output->writeln("Fertig");
    }
}