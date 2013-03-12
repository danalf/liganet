<?php

namespace Liganet\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SpielArtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('nameKurz')
            ->add('anzahlSpieler')
            ->add('mixte')
            ->add('nummer')
            ->add('reihenfolge')
            ->add('modus')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Liganet\CoreBundle\Entity\SpielArt'
        ));
    }

    public function getName()
    {
        return 'liganet_corebundle_spielarttype';
    }
    

}
