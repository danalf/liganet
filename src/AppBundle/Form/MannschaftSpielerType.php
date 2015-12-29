<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class MannschaftSpielerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $spieler_disabled=false;
        if( is_object($options["data"]->getSpieler())){
            $spieler_disabled=true;
        }
        
        if( is_object($options["data"]->getMannschaft())){
            $verein = $options["data"]->getMannschaft()->getVerein();
        $builder
            ->add('spieler', 'entity', array(
                'required' => false,
                'class' => 'Liganet\CoreBundle\Entity\Spieler',
                'query_builder' => function(EntityRepository $er) use ($verein) {
                    return $er->createQueryBuilder('s')
                        ->innerJoin('s.verein','v',  'WITH', 'v.id ='.$verein->getId())
                        ->orderBy('s.nachname', 'ASC')
                        ->where('s.nummerlizenz > 0');
                },
                'required' => true,
                'empty_value' => 'Wähle einen Spieler',
                'disabled'    => $spieler_disabled,
            ));
        } else {
        $builder
            ->add('spieler');
        }
        $builder
            ->add('status','entity', array(
                        'class' => 'Liganet\CoreBundle\Entity\SpielerStatus',
                        'required' => true,
                    ))
            ->add('mannschaft','entity', array(
                        'class' => 'Liganet\CoreBundle\Entity\Mannschaft',
                        'disabled' => true,
                    ));
        
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Liganet\CoreBundle\Entity\MannschaftSpieler'
        ));
    }

}
