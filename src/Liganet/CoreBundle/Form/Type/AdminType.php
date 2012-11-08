<?php

namespace Liganet\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AdminType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('roleList', 'choice', array(
            'choices' => array(
            'ROLE_CAPTAIN' => 'ROLE_CAPTAIN',
            'ROLE_CLUB_MANAGEMENT' => 'ROLE_CLUB_MANAGEMENT',
            'ROLE_LEAGUE_MANAGEMENT' => 'ROLE_LEAGUE_MANAGEMENT',
            'ROLE_REGION_MANAGEMENT' => 'ROLE_REGION_MANAGEMENT',
            'ROLE_UNION_MANAGEMENT' => 'ROLE_UNION_MANAGEMENT',
            'ROLE_UNION_MANAGEMENT' => 'ROLE_UNION_MANAGEMENT',
            'ROLE_ADMIN' => 'ROLE_ADMIN',
            ),
            'property_path' => false,
            'multiple' => true,
        ));
    }

    public function getName() {
        return 'admin';
    }

}

