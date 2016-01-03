<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpielerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('anrede', 'entity', array(
            //        'class' => 'LiganetCoreBundle:Anrede',
            //        'empty_value' => 'Wähle das Geschlecht',
            //        ))
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
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Spieler'
        ));
    }
}
