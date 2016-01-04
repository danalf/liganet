<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
        $ligasaison=$options["data"]->getLigaSaison();
        $builder
            ->add('rang')
            ->add('bemerkung')
            ->add('verein');
             if (isset($ligasaison)){
                 $builder->add('ligasaison');
             }else {
                  $builder->add('ligasaison', EntityType::class, array(
                'required' => true,
                'class' => 'AppBundle\Entity\LigaSaison',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('ls')
                        ->where('ls.actual = true');
                       // ->orderBy('s.nachname', 'ASC');
                },
                'empty_data' => 'Wähle eine Liga',
                'label'     => 'Liga',
            ))
        ;
             }
       
        if (isset($verein)) {
            $builder->add('captain', EntityType::class, array(
                'required' => false,
                'class' => 'AppBundle\Entity\Spieler',
                'query_builder' => function(EntityRepository $er) use ($verein) {
                    return $er->createQueryBuilder('s')
                        ->innerJoin('s.verein','v',  'WITH', 'v.id ='.$verein->getId())
                        ->orderBy('s.nachname', 'ASC');
                },
                'empty_data' => 'Wähle einen Kapitän',
                'label'     => 'Kapitän',
            ));
        }
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
