<?php

namespace Liganet\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class MannschaftType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $verein = $options["data"]->getVerein();
        $builder
            ->add('rang')
            ->add('bemerkung')
            ->add('verein')
            ->add('ligasaison')
        ;
        if (isset($verein)) {
            $builder->add('captain', 'entity', array(
                'required' => false,
                'class' => 'Liganet\CoreBundle\Entity\Spieler',
                'query_builder' => function(EntityRepository $er) use ($verein) {
                    return $er->createQueryBuilder('s')
                        ->innerJoin('s.verein','v',  'WITH', 'v.id ='.$verein->getId())
                        ->orderBy('s.nachname', 'ASC');
                },
                'empty_value' => 'Wähle einen Kapitän',
            ));
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Liganet\CoreBundle\Entity\Mannschaft'
        ));
    }

    public function getName()
    {
        return 'liganet_corebundle_mannschafttype';
    }
}
