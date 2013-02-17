<?php

namespace Liganet\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class VereinType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $verein = $options["data"]->getId();
        $builder
                ->add('name')
                ->add('namekurz')
                ->add('kuerzel')
                ->add('nummer')
                ->add('homepage')
                ->add('document')
                ->add('region')
        ;
        if (isset($verein)) {
            $builder->add('kontakt', 'entity', array(
                'class' => 'Liganet\CoreBundle\Entity\Spieler',
                'query_builder' => function(EntityRepository $er) use($verein) {
                    return $er->createQueryBuilder('u')
                                    ->where('u.verein = :id')
                                    ->setParameter('id', $verein);
                },
                'required' => false,
                'empty_value' => 'Wähle einen Kontakt',
            ));
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Liganet\CoreBundle\Entity\Verein'
        ));
    }

    public function getName() {
        return 'liganet_corebundle_vereintype';
    }

}
