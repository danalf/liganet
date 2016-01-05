<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\ErgebnisType;

class BegegnungType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $begegnung = $builder->getData();

        //echo "<pre>";
        //\Doctrine\Common\Util\Debug::dump($begegnung); 
        //\Doctrine\Common\Util\Debug::dump($begegnung->getErgebnisse()); 
        //echo "</pre>";
        $builder
                ->add('ergebnisse', CollectionType::class, array(
                    'entry_type' => ErgebnisType::class,
                ))
                ->add('unterschrift1')
                ->add('unterschrift2')
                ->add('unterschriftLeiter')
                ->add('bemerkung')
                ->add('save', SubmitType::class, ['label' => 'Speichern'])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Begegnung'
        ));
    }

}
