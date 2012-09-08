<?php

namespace PositiveThinking\Bundle\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ThingType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', 'textarea')
            ->add('date')
            // Seems like Symfony needs to be told that checkboxes might not be checked
            ->add('favoriteDay', 'checkbox', array('required' => false))
            ->add('favoriteWeek', 'checkbox', array('required' => false))
            ->add('favoriteMonth', 'checkbox', array('required' => false))
            ->add('favoriteYear', 'checkbox', array('required' => false))
        ;
    }

    public function getName()
    {
        return 'positivethinking_bundle_mainbundle_thingtype';
    }
}
