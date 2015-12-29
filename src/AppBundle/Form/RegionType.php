<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

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
            ->add('leiter', 'entity', array(
                'class' => 'Liganet\CoreBundle\Entity\Spieler',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                            ->orderBy('s.vorname, s.nachname', 'ASC');
                },
                'required' => false,
                'empty_value' => 'Wähle einen Kontakt',
                'multiple'  => true,
            ));
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Liganet\CoreBundle\Entity\Region'
        ));
    }

}