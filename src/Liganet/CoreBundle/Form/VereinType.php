<?php

namespace Liganet\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VereinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('namekurz')
            ->add('kuerzel')
            ->add('nummer')
            ->add('kontakt')
            ->add('homepage')
            ->add('document')
            ->add('region')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Liganet\CoreBundle\Entity\Verein'
        ));
    }

    public function getName()
    {
        return 'liganet_corebundle_vereintype';
    }
}
