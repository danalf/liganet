<?php

namespace Liganet\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ErgebnisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $mannschaft=0;
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
                'query_builder' => function(EntityRepository $er) use ($mannschaft) {
                    return $er->createQueryBuilder('s')
                        ->innerJoin('s.mannschaftSpieler','ms')
                        ->innerJoin('ms.mannschaft','m',  'WITH', 'm.id =62')
                        ->orderBy('s.nummerlizenz', 'ASC');
                },
                'empty_value' => '',
            ))
            ->add('spieler1_2')
            ->add('spieler1_3')
            ->add('spieler2_1')
            ->add('spieler2_2')
            ->add('spieler2_3')
            ->add('ersatz1')
            ->add('ersatzFuer1')
            ->add('ersatz2')
            ->add('ersatzFuer2')
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
