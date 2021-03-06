<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityRepository;

class MannschaftType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $verein = $options["data"]->getVerein();
        $ligasaison = $options["data"]->getLigaSaison();
        $builder
                ->add('rang')
                ->add('bemerkung');
        if (!isset($ligasaison)) {
            $builder->add('verein');;
        } else {
            $builder->add('verein', EntityType::class, array(
                'required' => true,
                'class' => 'AppBundle\Entity\Verein',
                'query_builder' => function(EntityRepository $er) use ($ligasaison) {
                    return $er->createQueryBuilder('v')
                                    ->join("v.region", "r")
                                    ->where('r = ?1')
                                    ->setParameter(1, $ligasaison->getLiga()->getRegion()->getId());
                },
                'placeholder' => 'Wähle einen Verein',
                'label' => 'Verein',
            ))
            ;
        }
                
        if (isset($ligasaison)) {
            $builder->add('ligasaison');
        } else {
            $builder->add('ligasaison', EntityType::class, array(
                'required' => true,
                'class' => 'AppBundle\Entity\LigaSaison',
                'query_builder' => function(EntityRepository $er) use ($verein) {
                    return $er->createQueryBuilder('ls')
                                    ->join("ls.liga", "l")
                                    ->join("l.region", "r")
                                    ->where('ls.actual = true')
                                    ->andWhere('r = ?1')
                                    ->setParameter(1, $verein->getRegion()->getId());
                },
                'placeholder' => 'Wähle eine Liga',
                'label' => 'Liga',
            ))
            ;
        }

        if (isset($verein)) {
            $builder->add('captain', EntityType::class, array(
                'required' => false,
                'class' => 'AppBundle\Entity\Spieler',
                'query_builder' => function(EntityRepository $er) use ($verein) {
                    return $er->createQueryBuilder('s')
                                    ->innerJoin('s.verein', 'v', 'WITH', 'v.id =' . $verein->getId())
                                    ->orderBy('s.nachname', 'ASC');
                },
                'placeholder' => 'Wähle einen Kapitän',
                'label' => 'Kapitän',
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
            'data_class' => 'AppBundle\Entity\Mannschaft'
        ));
    }

}
