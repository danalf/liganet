<?php

namespace AppBundle\Form;

use AppBundle\Security\MannschaftSpielerVoter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class MannschaftSpielerType extends AbstractType
{
    private $_authorizationChecker;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $mannschaftSpieler =  $options["data"];
        $spieler_disabled = false;
        if (is_object($options["data"]->getSpieler())) {
            $spieler_disabled = true;
        }
        if (is_object($options["data"]->getMannschaft())) {
            $verein = $options["data"]->getMannschaft()->getVerein();
            $saison = $options["data"]->getMannschaft()->getLigasaison()->getSaison()->getSaison();
            $builder
                    ->add('spieler', EntityType::class, array(
                        'required' => false,
                        'class' => 'AppBundle\Entity\Spieler',
                        'query_builder' => function(EntityRepository $er) use ($verein, $saison) {
                            return $er->createQueryBuilder('s')
                                    ->innerJoin('s.verein', 'v', 'WITH', 'v.id =' . $verein->getId())
                                    ->innerJoin('s.spielerExtern', 'se')
                                    ->orderBy('s.nachname', 'ASC')
                                    ->where('s.nummerlizenz > 0')
                                    ->andWhere("se.lizenzJahr = $saison");
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
        ;
        if ($this->_authorizationChecker->isGranted(MannschaftSpielerVoter::CONFIRM, $mannschaftSpieler)) {
            $builder->add('bestaetigt');
        } else {
            $builder->add(
                'bestaetigt',
                CheckboxType::class, array('disabled' => true)
            );
        }
        $builder->add('save', SubmitType::class, ['label' => 'Speichern']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\MannschaftSpieler'
            )
        );
    }

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->_authorizationChecker = $authorizationChecker;
    }

}
