<?php

namespace Liganet\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegionType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name');
        $builder->add('name_kurz');
        $builder->add('document', new DocumentType());
        $builder->add('description', 'textarea', array('required' => false));
        $builder->add('farbeTabelleSchrift');
        $builder->add('farbeTabelleHintergrund');
        $builder->add('farbeTabelleZeile2Schrift');
        $builder->add('farbeTabelleZeile2Hintergrund');
        $builder->add('verband', 'entity', array(
            'class' => 'LiganetCoreBundle:Verband',
            'property' => 'name',
        ));
    }

    public function getName() {
        return 'region';
    }

}