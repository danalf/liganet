<?php

namespace Liganet\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LigaSaisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('saison')
            ->add('liga')
            ->add('gesperrt')
            ->add('actual')
            ->add('bemerkung')
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Liganet\CoreBundle\Entity\LigaSaison'
        ));
    }

    public function getName()
    {
        return 'liganet_corebundle_ligasaisontype';
    }
}
