<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LigaType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
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
                ->add('save', SubmitType::class, ['label' => 'Speichern'])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Liga'
        ));
    }

}
