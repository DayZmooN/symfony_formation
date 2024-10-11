<?php

namespace App\Form;

use App\Dto\ContactDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Nom',
                'empty_data'=>''
            ])
            ->add('email',EmailType::class,[
                'label' => 'Email',
                'empty_data'=>''
            ])
            ->add('message'
            ,TextareaType::class,[
                'label' => 'Message',
                    'empty_data'=>''
                ])
            ->add('save', SubmitType::class,[
                'label' => 'Envoyer'
            ])
            ->add('service',ChoiceType::class,[
                'choices' => [
                    'Compta' => 'Comptat@demo.fr',
                    'Service' => 'Service@demo.fr',
                    'Marketing' => 'Marketing@demo.fr',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactDTO::class,
        ]);
    }
}
