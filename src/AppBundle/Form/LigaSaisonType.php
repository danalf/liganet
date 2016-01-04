<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class LigaSaisonType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('saison')
            ->add('liga')
            ->add('gesperrt')
            ->add('actual')
            ->add('bemerkung')
            ->add('staffelleiter', EntityType::class, array(
                'class' => 'AppBundle\Entity\Spieler',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                            ->orderBy('s.vorname, s.nachname', 'ASC');
                },
                'required' => false,
                'placeholder' => 'Wähle einen Kontakt',
                'multiple'  => true,
            ));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\LigaSaison'
        ));
    }
}
