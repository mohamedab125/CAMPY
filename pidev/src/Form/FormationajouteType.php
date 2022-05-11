<?php

namespace App\Form;

use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\DBAL\Types\VarDateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\VarDumper\Caster\DateCaster;

class FormationajouteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
        ->add('nom')
        ->add('nom_formateur')
        ->add('date_deb',DateType::class)
        ->add('date_fin',DateType::class)
        ->add('prix')
        ->add('description')
        ->add('user_id')
        ->add('ajouter',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
