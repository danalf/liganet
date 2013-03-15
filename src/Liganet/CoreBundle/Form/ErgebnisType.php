<?php

namespace Liganet\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ErgebnisType extends AbstractType
{
    private $session;
        public function __construct($session)
        {
            $this->session = $session;
        }
        
        
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $mannschaft1=$this->session->get('mannschaft1');
        $mannschaft2=$this->session->get('mannschaft2');
        $builder
            //->add('platz')
            //->add('bemerkung')
            ->add('kugeln1')
            ->add('kugeln2')
            //->add('begegnung')
            //->add('spielArt')
            ->add('spieler1_1','entity', array(
                'required' => false,
                'property' => 'nameWithLizenz',
                'class' => 'Liganet\CoreBundle\Entity\Spieler',
                'query_builder' => function(EntityRepository $er) use ($mannschaft1) {
                    return $er->createQueryBuilder('s')
                        ->innerJoin('s.mannschaftSpieler','ms')
                        ->innerJoin('ms.mannschaft','m',  'WITH', 'm.id ='.$mannschaft1)
                        ->orderBy('s.nummerlizenz', 'ASC');
                },
                'empty_value' => '',
            ))
            ->add('spieler1_2','entity', array(
                'required' => false,
                'property' => 'nameWithLizenz',
                'class' => 'Liganet\CoreBundle\Entity\Spieler',
                'query_builder' => function(EntityRepository $er) use ($mannschaft1) {
                    return $er->createQueryBuilder('s')
                        ->innerJoin('s.mannschaftSpieler','ms')
                        ->innerJoin('ms.mannschaft','m',  'WITH', 'm.id ='.$mannschaft1)
                        ->orderBy('s.nummerlizenz', 'ASC');
                },
                'empty_value' => '',
            ))
            ->add('spieler1_3','entity', array(
                'required' => false,
                'property' => 'nameWithLizenz',
                'class' => 'Liganet\CoreBundle\Entity\Spieler',
                'query_builder' => function(EntityRepository $er) use ($mannschaft1) {
                    return $er->createQueryBuilder('s')
                        ->innerJoin('s.mannschaftSpieler','ms')
                        ->innerJoin('ms.mannschaft','m',  'WITH', 'm.id ='.$mannschaft1)
                        ->orderBy('s.nummerlizenz', 'ASC');
                },
                'empty_value' => '',
            ))
            ->add('spieler2_1','entity', array(
                'required' => false,
                'property' => 'nameWithLizenz',
                'class' => 'Liganet\CoreBundle\Entity\Spieler',
                'query_builder' => function(EntityRepository $er) use ($mannschaft2) {
                    return $er->createQueryBuilder('s')
                        ->innerJoin('s.mannschaftSpieler','ms')
                        ->innerJoin('ms.mannschaft','m',  'WITH', 'm.id ='.$mannschaft2)
                        ->orderBy('s.nummerlizenz', 'ASC');
                },
                'empty_value' => '',
            ))
            ->add('spieler2_2','entity', array(
                'required' => false,
                'property' => 'nameWithLizenz',
                'class' => 'Liganet\CoreBundle\Entity\Spieler',
                'query_builder' => function(EntityRepository $er) use ($mannschaft2) {
                    return $er->createQueryBuilder('s')
                        ->innerJoin('s.mannschaftSpieler','ms')
                        ->innerJoin('ms.mannschaft','m',  'WITH', 'm.id ='.$mannschaft2)
                        ->orderBy('s.nummerlizenz', 'ASC');
                },
                'empty_value' => '',
            ))
            ->add('spieler2_3','entity', array(
                'required' => false,
                'property' => 'nameWithLizenz',
                'class' => 'Liganet\CoreBundle\Entity\Spieler',
                'query_builder' => function(EntityRepository $er) use ($mannschaft2) {
                    return $er->createQueryBuilder('s')
                        ->innerJoin('s.mannschaftSpieler','ms')
                        ->innerJoin('ms.mannschaft','m',  'WITH', 'm.id ='.$mannschaft2)
                        ->orderBy('s.nummerlizenz', 'ASC');
                },
                'empty_value' => '',
            ))
            
            ->add('ersatz1','entity', array(
                'required' => false,
                'property' => 'nameWithLizenz',
                'class' => 'Liganet\CoreBundle\Entity\Spieler',
                'query_builder' => function(EntityRepository $er) use ($mannschaft1) {
                    return $er->createQueryBuilder('s')
                        ->innerJoin('s.mannschaftSpieler','ms')
                        ->innerJoin('ms.mannschaft','m',  'WITH', 'm.id ='.$mannschaft1)
                        ->orderBy('s.nummerlizenz', 'ASC');
                },
                'empty_value' => '',
            ))
            ->add('ersatzFuer1','entity', array(
                'required' => false,
                'property' => 'nameWithLizenz',
                'class' => 'Liganet\CoreBundle\Entity\Spieler',
                'query_builder' => function(EntityRepository $er) use ($mannschaft1) {
                    return $er->createQueryBuilder('s')
                        ->innerJoin('s.mannschaftSpieler','ms')
                        ->innerJoin('ms.mannschaft','m',  'WITH', 'm.id ='.$mannschaft1)
                        ->orderBy('s.nummerlizenz', 'ASC');
                },
                'empty_value' => '',
            ))
->add('ersatz2','entity', array(
                'required' => false,
                'property' => 'nameWithLizenz',
                'class' => 'Liganet\CoreBundle\Entity\Spieler',
                'query_builder' => function(EntityRepository $er) use ($mannschaft2) {
                    return $er->createQueryBuilder('s')
                        ->innerJoin('s.mannschaftSpieler','ms')
                        ->innerJoin('ms.mannschaft','m',  'WITH', 'm.id ='.$mannschaft2)
                        ->orderBy('s.nummerlizenz', 'ASC');
                },
                'empty_value' => '',
            ))
            ->add('ersatzFuer2','entity', array(
                'required' => false,
                'property' => 'nameWithLizenz',
                'class' => 'Liganet\CoreBundle\Entity\Spieler',
                'query_builder' => function(EntityRepository $er) use ($mannschaft2) {
                    return $er->createQueryBuilder('s')
                        ->innerJoin('s.mannschaftSpieler','ms')
                        ->innerJoin('ms.mannschaft','m',  'WITH', 'm.id ='.$mannschaft2)
                        ->orderBy('s.nummerlizenz', 'ASC');
                },
                'empty_value' => '',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Liganet\CoreBundle\Entity\Ergebnis'
        ));
    }

    public function getName()
    {
        return 'liganet_corebundle_ergebnistype';
    }
    
    
}
