<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ErgebnisType extends AbstractType
{

    private $mannschaft1;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $ergebnis = $event->getData();
            $mannschaft1 = $ergebnis->getBegegnung()->getMannschaft1()->getId();
            $mannschaft2 = $ergebnis->getBegegnung()->getMannschaft2()->getId();
            $form = $event->getForm();
            $form
                    ->add('spieler1_1', EntityType::class, array(
                        'required' => false,
                        'class' => 'AppBundle\Entity\Spieler',
                        'query_builder' => function(EntityRepository $er) use ($mannschaft1) {
                            return $er->createQueryBuilder('s')
                                    ->innerJoin('s.mannschaftSpieler', 'ms')
                                    ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id = :id')
                                    ->orderBy('s.nummerlizenz', 'ASC')
                                    ->setParameter('id', $mannschaft1)
                            ;
                        },
                        'placeholder' => '',
                    ))
                    ->add('spieler1_2', EntityType::class, array(
                        'required' => false,
                        'class' => 'AppBundle\Entity\Spieler',
                        'query_builder' => function(EntityRepository $er) use ($mannschaft1) {
                            return $er->createQueryBuilder('s')
                                    ->innerJoin('s.mannschaftSpieler', 'ms')
                                    ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id = :id')
                                    ->orderBy('s.nummerlizenz', 'ASC')
                                    ->setParameter('id', $mannschaft1)
                            ;
                        },
                        'placeholder' => '',
                    ))
                    ->add('spieler1_3', EntityType::class, array(
                        'required' => false,
                        'class' => 'AppBundle\Entity\Spieler',
                        'query_builder' => function(EntityRepository $er) use ($mannschaft1) {
                            return $er->createQueryBuilder('s')
                                    ->innerJoin('s.mannschaftSpieler', 'ms')
                                    ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id = :id')
                                    ->orderBy('s.nummerlizenz', 'ASC')
                                    ->setParameter('id', $mannschaft1)
                            ;
                        },
                        'placeholder' => '',
                    ))
                    ->add('ersatz1', EntityType::class, array(
                        'required' => false,
                        'class' => 'AppBundle\Entity\Spieler',
                        'query_builder' => function(EntityRepository $er) use ($mannschaft1) {
                            return $er->createQueryBuilder('s')
                                    ->innerJoin('s.mannschaftSpieler', 'ms')
                                    ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id = :id')
                                    ->orderBy('s.nummerlizenz', 'ASC')
                                    ->setParameter('id', $mannschaft1)
                            ;
                        },
                        'placeholder' => '',
                    ))
                    ->add('ersatzFuer1', EntityType::class, array(
                        'required' => false,
                        'class' => 'AppBundle\Entity\Spieler',
                        'query_builder' => function(EntityRepository $er) use ($mannschaft1) {
                            return $er->createQueryBuilder('s')
                                    ->innerJoin('s.mannschaftSpieler', 'ms')
                                    ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id = :id')
                                    ->orderBy('s.nummerlizenz', 'ASC')
                                    ->setParameter('id', $mannschaft1)
                            ;
                        },
                        'placeholder' => '',
                    ))
                    ->add('spieler2_1', EntityType::class, array(
                        'required' => false,
                        'class' => 'AppBundle\Entity\Spieler',
                        'query_builder' => function(EntityRepository $er) use ($mannschaft2) {
                            return $er->createQueryBuilder('s')
                                    ->innerJoin('s.mannschaftSpieler', 'ms')
                                    ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id = :id')
                                    ->orderBy('s.nummerlizenz', 'ASC')
                                    ->setParameter('id', $mannschaft2)
                            ;
                        },
                        'placeholder' => '',
                    ))
                    ->add('spieler2_2', EntityType::class, array(
                        'required' => false,
                        'class' => 'AppBundle\Entity\Spieler',
                        'query_builder' => function(EntityRepository $er) use ($mannschaft2) {
                            return $er->createQueryBuilder('s')
                                    ->innerJoin('s.mannschaftSpieler', 'ms')
                                    ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id = :id')
                                    ->orderBy('s.nummerlizenz', 'ASC')
                                    ->setParameter('id', $mannschaft2)
                            ;
                        },
                        'placeholder' => '',
                    ))
                    ->add('spieler2_3', EntityType::class, array(
                        'required' => false,
                        'class' => 'AppBundle\Entity\Spieler',
                        'query_builder' => function(EntityRepository $er) use ($mannschaft2) {
                            return $er->createQueryBuilder('s')
                                    ->innerJoin('s.mannschaftSpieler', 'ms')
                                    ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id = :id')
                                    ->orderBy('s.nummerlizenz', 'ASC')
                                    ->setParameter('id', $mannschaft2)
                            ;
                        },
                        'placeholder' => '',
                    ))
                    ->add('ersatz2', EntityType::class, array(
                        'required' => false,
                        'class' => 'AppBundle\Entity\Spieler',
                        'query_builder' => function(EntityRepository $er) use ($mannschaft2) {
                            return $er->createQueryBuilder('s')
                                    ->innerJoin('s.mannschaftSpieler', 'ms')
                                    ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id = :id')
                                    ->orderBy('s.nummerlizenz', 'ASC')
                                    ->setParameter('id', $mannschaft2)
                            ;
                        },
                        'placeholder' => '',
                    ))
                    ->add('ersatzFuer2', EntityType::class, array(
                        'required' => false,
                        'class' => 'AppBundle\Entity\Spieler',
                        'query_builder' => function(EntityRepository $er) use ($mannschaft2) {
                            return $er->createQueryBuilder('s')
                                    ->innerJoin('s.mannschaftSpieler', 'ms')
                                    ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id = :id')
                                    ->orderBy('s.nummerlizenz', 'ASC')
                                    ->setParameter('id', $mannschaft2)
                            ;
                        },
                        'placeholder' => '',
                    ))
            ;
        });

        $builder
                ->add('kugeln1')
                ->add('kugeln2')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Ergebnis',
        ));
    }

}
