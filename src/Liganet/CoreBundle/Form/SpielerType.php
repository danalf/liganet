<?php

namespace Liganet\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SpielerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anrede', 'entity', array(
                    'class' => 'LiganetCoreBundle:Anrede',
                    'empty_value' => 'Wähle das Geschlecht',
                    ))
            ->add('vorname')
            ->add('nachname')
            ->add('verein')
            ->add('nummerlizenz')
            ->add('email')
            ->add('telefon')
            ->add('fax')
            ->add('trainer')
            ->add('schiedsrichter')  
            ->add('strasse')
            ->add('lkz')
            ->add('plz')
            ->add('ort')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Liganet\CoreBundle\Entity\Spieler'
        ));
    }

    public function getName()
    {
        return 'liganet_corebundle_spielertype';
    }
}
