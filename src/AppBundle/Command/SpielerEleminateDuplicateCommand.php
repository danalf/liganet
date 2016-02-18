<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class SpielerEleminateDuplicateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:spieler:duplicate')
            ->setDescription('Eleminate spieler duplicates')
            ->addArgument(
                'firstId',
                InputArgument::REQUIRED,
                'original id'
            )
            ->addArgument(
                'secondId',
                InputArgument::REQUIRED,
                'duplicate id'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id1 = $input->getArgument('firstId');
        $id2 = $input->getArgument('secondId');
        $em = $this->getContainer()->get('doctrine')->getManager('default');

        $connection = $em->getConnection();
        $query = $em->createQuery("UPDATE AppBundle\Entity\MannschaftSpieler s SET s.spieler = :id1 WHERE s.spieler = :id2");
        $query->setParameter('id1', $id1);
        $query->setParameter('id2', $id2);
        $result = $query->getResult();
        $output->writeln($result);

        $query = $em->createQuery("UPDATE AppBundle\Entity\Mannschaft m SET m.captain = :id1 WHERE m.captain = :id2");
        $query->setParameter('id1', $id1);
        $query->setParameter('id2', $id2);
        $result = $query->getResult();
        $output->writeln($result);
        
        $fields = ["spieler1_1","spieler1_2","spieler1_3","spieler2_1","spieler2_2","spieler2_3","ersatz1","ersatz2","ersatzFuer1","ersatzFuer2"];
        foreach ($fields as $field) {
            $query = $em->createQuery("UPDATE AppBundle\Entity\Ergebnis e SET e.$field = :id1 WHERE e.$field = :id2");
            $query->setParameter('id1', $id1);
            $query->setParameter('id2', $id2);
            $result = $query->getResult();
            $output->writeln($result);
        }
        
        $statement = $connection->prepare("DELETE FROM ln_spieler WHERE id = :id2");
        $statement->bindValue('id2', $id2);
        $statement->execute();
            
        $output->writeln("Fertig");
    }
}