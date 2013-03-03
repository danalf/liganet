<?php

namespace Liganet\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LigaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('farbeTabellenKopf')
            ->add('farbeTabellenKopfSchrift')
            ->add('farbeUeberschriftHintergrund')
            ->add('farbeUeberschrift')
            ->add('email')
            ->add('kuerzel')
            ->add('bemerkung')
            ->add('newsfeed')
            ->add('region')
            ->add('modus')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Liganet\CoreBundle\Entity\Liga'
        ));
    }

    public function getName()
    {
        return 'liganet_corebundle_ligatype';
    }
}
