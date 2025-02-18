<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, ['attr'=>['class'=>'form-control'], 'label'=>'Email'])
            ->add('first_name', TextType::class, ['attr'=>['class'=>'form-control'], 'label'=>'Nombre'])
            ->add('last_name', TextType::class, ['attr'=>['class'=>'form-control'], 'label'=>'Apellido'])
            ->add('clientes', EntityType::class, [
                'class' => Customer::class,
                'choice_label'=>'name',
                'multiple'=>true,
                // function($element){
                //     return $element->getName()." - ". $element->getCuit();
                // },
                'placeholder' => '',
                'required'=>false,
                'query_builder' => function (CustomerRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'attr'=>['class'=>'form-control '], 
                'label'=>'Clientes habilitados'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
