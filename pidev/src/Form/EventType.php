<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;





class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
     
    
        
            ->add('nom')
            ->add('nbreDeplaces')
            ->add('Type')
            ->add('prix')
            ->add('date')
            ->add('image', FileType::class,
            array(
                'required'=>false,

                'attr' => array(
                    'accept' => "image/jpeg, image/png"
                ),
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a JPG or PNG',
                        ])
                        ]
                    ))
                    
                    ->add('ajouter',SubmitType::class)
                    ->add('captchaCode', CaptchaType::class, array(
                        'captchaConfig' => 'ExampleCaptchaUserRegistration',
                        'constraints' => [
                            new ValidCaptcha([
                                'message' => 'Invalid captcha, please try again',
                            ]),
                        ],
                    ))
                
                

;

                
            }
        
            public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}