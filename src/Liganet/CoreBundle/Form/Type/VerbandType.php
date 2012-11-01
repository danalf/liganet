<?php

namespace Liganet\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class VerbandType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name');
        $builder->add('name_kurz');
        $builder->add('document', new DocumentType());
        $builder->add('number', 'integer');
        $builder->add('description', 'textarea', array('required' => false));
    }

    public function getName() {
        return 'verband';
    }
    

}