<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Doctrine\ORM\EntityRepository;

class VereinType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $verein = $options["data"]->getId();
        $builder
                ->add('name')
                ->add('namekurz')
                ->add('kuerzel')
                ->add('nummer')
                ->add('homepage')
                ->add('document')
                ->add('region')
                ->add('imageFile', VichImageType::class, array(
                    'required' => false,
                    'allow_delete' => true,
                    'download_link' => true,
                ));
        if (isset($verein)) {
            $builder->add('leiter', EntityType::class, array(
                'class' => 'AppBundle\Entity\Spieler',
                'query_builder' => function(EntityRepository $er) use($verein) {
                    return $er->createQueryBuilder('u')
                                    ->where('u.verein = :id')
                                    ->setParameter('id', $verein);
                },
                'required' => false,
                'placeholder' => 'Wähle einen Kontakt',
                'multiple' => true,
            ));
        }
        $builder->add('save', SubmitType::class, ['label' => 'Speichern']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Verein'
        ));
    }

}
