<?php

namespace Liganet\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('name_kurz')
            ->add('description')
            ->add('farbeTabelleSchrift')
            ->add('farbeTabelleHintergrund')
            ->add('farbeTabelleZeile2Schrift')
            ->add('farbeTabelleZeile2Hintergrund')
            ->add('document')
            ->add('verband')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Liganet\CoreBundle\Entity\Region'
        ));
    }

    public function getName()
    {
        return 'liganet_corebundle_regiontype';
    }
}
