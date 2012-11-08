<?php

namespace Liganet\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SpielerType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name');
        $builder->add('vorname');
        $builder->add('verein', 'entity', array(
            'class' => 'LiganetCoreBundle:Verein',
            'property' => 'name',
            'empty_value' => 'Wähle einen Verein',
        ));
    }

    public function getName() {
        return 'spieler';
    }

}