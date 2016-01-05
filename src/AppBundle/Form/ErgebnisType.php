<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class ErgebnisType extends AbstractType
{
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$ergebnis = $builder->getData();
        //     \Doctrine\Common\Util\Debug::dump($ergebnis); 
        //$mannschaft1 = $ergebnis->getMannschaft1();
        //$mannschaft2 = $ergebnis->getMannschaft2();
        $builder->add('spieler1_1')
                //->add('kugeln1')
                //->add('kugeln2')
                /*->add('spieler1_1', EntityType::class, array(
                    'required' => false,
                    'property' => 'nameWithLizenz',
                    'class' => 'AppBundle\Entity\Spieler',
                    'query_builder' => function(EntityRepository $er) use ($mannschaft1) {
                        return $er->createQueryBuilder('s')
                                ->innerJoin('s.mannschaftSpieler', 'ms')
                                ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id =' . $mannschaft1)
                                ->orderBy('s.nummerlizenz', 'ASC');
                    },
                    'placeholder' => '',
                ))
                ->add('spieler1_2', EntityType::class, array(
                    'required' => false,
                    'property' => 'nameWithLizenz',
                    'class' => 'AppBundle\Entity\Spieler',
                    'query_builder' => function(EntityRepository $er) use ($mannschaft1) {
                        return $er->createQueryBuilder('s')
                                ->innerJoin('s.mannschaftSpieler', 'ms')
                                ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id =' . $mannschaft1)
                                ->orderBy('s.nummerlizenz', 'ASC');
                    },
                    'placeholder' => '',
                ))
                ->add('spieler1_3', EntityType::class, array(
                    'required' => false,
                    'property' => 'nameWithLizenz',
                    'class' => 'AppBundle\Entity\Spieler',
                    'query_builder' => function(EntityRepository $er) use ($mannschaft1) {
                        return $er->createQueryBuilder('s')
                                ->innerJoin('s.mannschaftSpieler', 'ms')
                                ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id =' . $mannschaft1)
                                ->orderBy('s.nummerlizenz', 'ASC');
                    },
                    'placeholder' => '',
                ))
                ->add('spieler2_1', EntityType::class, array(
                    'required' => false,
                    'property' => 'nameWithLizenz',
                    'class' => 'AppBundle\Entity\Spieler',
                    'query_builder' => function(EntityRepository $er) use ($mannschaft2) {
                        return $er->createQueryBuilder('s')
                                ->innerJoin('s.mannschaftSpieler', 'ms')
                                ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id =' . $mannschaft2)
                                ->orderBy('s.nummerlizenz', 'ASC');
                    },
                    'placeholder' => '',
                ))
                ->add('spieler2_2', EntityType::class, array(
                    'required' => false,
                    'property' => 'nameWithLizenz',
                    'class' => 'AppBundle\Entity\Spieler',
                    'query_builder' => function(EntityRepository $er) use ($mannschaft2) {
                        return $er->createQueryBuilder('s')
                                ->innerJoin('s.mannschaftSpieler', 'ms')
                                ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id =' . $mannschaft2)
                                ->orderBy('s.nummerlizenz', 'ASC');
                    },
                    'placeholder' => '',
                ))
                ->add('spieler2_3', EntityType::class, array(
                    'required' => false,
                    'property' => 'nameWithLizenz',
                    'class' => 'AppBundle\Entity\Spieler',
                    'query_builder' => function(EntityRepository $er) use ($mannschaft2) {
                        return $er->createQueryBuilder('s')
                                ->innerJoin('s.mannschaftSpieler', 'ms')
                                ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id =' . $mannschaft2)
                                ->orderBy('s.nummerlizenz', 'ASC');
                    },
                    'placeholder' => '',
                ))
                ->add('ersatz1', EntityType::class, array(
                    'required' => false,
                    'property' => 'nameWithLizenz',
                    'class' => 'AppBundle\Entity\Spieler',
                    'query_builder' => function(EntityRepository $er) use ($mannschaft1) {
                        return $er->createQueryBuilder('s')
                                ->innerJoin('s.mannschaftSpieler', 'ms')
                                ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id =' . $mannschaft1)
                                ->orderBy('s.nummerlizenz', 'ASC');
                    },
                    'placeholder' => '',
                ))
                ->add('ersatzFuer1', EntityType::class, array(
                    'required' => false,
                    'property' => 'nameWithLizenz',
                    'class' => 'AppBundle\Entity\Spieler',
                    'query_builder' => function(EntityRepository $er) use ($mannschaft1) {
                        return $er->createQueryBuilder('s')
                                ->innerJoin('s.mannschaftSpieler', 'ms')
                                ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id =' . $mannschaft1)
                                ->orderBy('s.nummerlizenz', 'ASC');
                    },
                    'placeholder' => '',
                ))
                ->add('ersatz2', EntityType::class, array(
                    'required' => false,
                    'property' => 'nameWithLizenz',
                    'class' => 'AppBundle\Entity\Spieler',
                    'query_builder' => function(EntityRepository $er) use ($mannschaft2) {
                        return $er->createQueryBuilder('s')
                                ->innerJoin('s.mannschaftSpieler', 'ms')
                                ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id =' . $mannschaft2)
                                ->orderBy('s.nummerlizenz', 'ASC');
                    },
                    'placeholder' => '',
                ))
                ->add('ersatzFuer2', EntityType::class, array(
                    'required' => false,
                    'property' => 'nameWithLizenz',
                    'class' => 'AppBundle\Entity\Spieler',
                    'query_builder' => function(EntityRepository $er) use ($mannschaft2) {
                        return $er->createQueryBuilder('s')
                                ->innerJoin('s.mannschaftSpieler', 'ms')
                                ->innerJoin('ms.mannschaft', 'm', 'WITH', 'm.id =' . $mannschaft2)
                                ->orderBy('s.nummerlizenz', 'ASC');
                    },
                    'placeholder' => '',
                ))*/
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('constraints' => $collectionConstraint));

        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Ergebnis'
        ));
    }

}
