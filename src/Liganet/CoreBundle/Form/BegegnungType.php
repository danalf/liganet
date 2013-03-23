<?php

namespace Liganet\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BegegnungType extends AbstractType
{
    private $session;
        public function __construct($session)
        {
            $this->session = $session;
        }
        
        
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $begegnung=$options["data"];
        $builder
            ->add('ergebnisse', 'collection', array(
                'type' => new ErgebnisType($this->session),
                ))
            //->add('kugeln1')
            //->add('kugeln2')
            //->add('siege1')
            //->add('siege2')
            //->add('punkt1')
            //->add('punkt2')
            ->add('unterschrift1')
            ->add('unterschrift2')
            ->add('unterschriftLeiter')
            ->add('bemerkung')
            //->add('spielRunde')
            //->add('mannschaft1')
            //->add('mannschaft2')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Liganet\CoreBundle\Entity\Begegnung'
        ));
    }

    public function getName()
    {
        return 'liganet_corebundle_begegnungtype';
    }
}
