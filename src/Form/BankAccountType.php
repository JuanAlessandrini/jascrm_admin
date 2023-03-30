<?php

namespace App\Form;

use App\Entity\BankAccount;
use App\Entity\Bank;
use App\Repository\BankRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BankAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('banco',EntityType::class, [
                'class'=>Bank::class,
                'choice_label'=>'name',
                'query_builder' => function (BankRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'attr'=>['class'=>'form-control js-choice-select'], 'label'=>'Banco'])
            ->add('cbu',TextType::class, ['required'=>true,
                    'attr'=>['max'=>'999999999999999999999', 'maxlength'=>'22','class'=>'form-control'], 
                    'label'=>'CBU',
                    'invalid_message'=>'El CBU debe contener 22 números'
                ]
                )
            ->add('sucursal',TextType::class, ['required'=>true,'attr'=>['class'=>'form-control'], 'label'=>'Sucursal'] )
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BankAccount::class,
        ]);
    }
}
