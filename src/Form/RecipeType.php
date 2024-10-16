<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Sequentially;

class RecipeType extends AbstractType
{
    public function __construct(private FormListenerFactory $listenerFactory)
    {

    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $builder
            ->add('title', TextType::class, [
                'label' => 'title *',
                'empty_data'=>''
            ])
            ->add('slug', TextType::class, [
                'label' => 'Slug',
                'required' => false,
//                'constraints'=> new Sequentially([
//                    new Length(['min' => 10]),
//                    new Regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', message: "ce slug n'est pas valide")
//                    ])
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Category *',
                'choice_label' => 'name',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Content *',
                'empty_data'=>''
            ])
            ->add('duration', IntegerType::class, [
                'label' => 'Duration *',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Envoyer',
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->listenerFactory->autoSlug('title'))
            ->addEventListener(FormEvents::POST_SUBMIT, $this->listenerFactory->timestamps());
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
