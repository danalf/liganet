<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityRepository;

class MannschaftSpielerType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $spieler_disabled = false;
        if (is_object($options["data"]->getSpieler())) {
            $spieler_disabled = true;
        }

        if (is_object($options["data"]->getMannschaft())) {
            $verein = $options["data"]->getMannschaft()->getVerein();
            $builder
                    ->add('spieler', EntityType::class, array(
                        'required' => false,
                        'class' => 'AppBundle\Entity\Spieler',
                        'query_builder' => function(EntityRepository $er) use ($verein) {
                            return $er->createQueryBuilder('s')
                                    ->innerJoin('s.verein', 'v', 'WITH', 'v.id =' . $verein->getId())
                                    ->orderBy('s.nachname', 'ASC')
                                    ->where('s.nummerlizenz > 0');
                        },
                        'required' => true,
                        'placeholder' => 'Wähle einen Spieler',
                        'disabled' => $spieler_disabled,
            ));
        } else {
            $builder
                    ->add('spieler');
        }
        $builder
                ->add('status', EntityType::class, array(
                    'class' => 'AppBundle\Entity\SpielerStatus',
                    'required' => true,
                ))
                ->add('mannschaft', EntityType::class, array(
                    'class' => 'AppBundle\Entity\Mannschaft',
                    'disabled' => true,
                ))
                ->add('save', SubmitType::class, ['label' => 'Speichern'])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MannschaftSpieler'
        ));
    }

}
