<?php

namespace Liganet\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class VereinType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name');
        $builder->add('region', 'entity', array(
            'class' => 'LiganetCoreBundle:Region',
            'property' => 'name',
            'empty_value' => 'Wähle eine Region',
        ));
    }

    public function getName() {
        return 'verein';
    }

}