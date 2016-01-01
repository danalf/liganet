<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegionType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
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
                ->add('leiter', EntityType::class, array(
                    'class' => 'AppBundle:Spieler',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('s')-> orderBy('s.vorname, s.nachname', 'ASC');
                    },
                    'required' => false,
                    'empty_data' => 'Wähle einen Kontakt',
                    'multiple' => true,
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Region'
        ));
    }

}
