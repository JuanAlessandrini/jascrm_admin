<?php

namespace App\Form;

use App\Entity\Cheque;
use App\Entity\Bank;
use App\Entity\BankAccount;
use App\Entity\Vendor;
use App\Repository\BankRepository;
use App\Repository\BankAccountRepository;
use App\Repository\VendorRepository;
use App\Repository\CustomerRepository;
use App\Repository\SubCuentaRepository;

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

class ChequeType extends AbstractType
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
        ->add('numero', NumberType::class, ['attr'=>['class'=>'form-control'], 'label'=>'Numero'])
            ->add('vencimiento', DateType::class, ['widget' => 'single_text','attr'=>['class'=>'form-control style-title text-uppercase'], 'label'=>'Vencimiento'])
            
            ->add('monto', NumberType::class, ['attr'=>['class'=>'form-control suma-total'], 'label'=>'Monto'])
            
            // ->add('sucursal')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cheque::class,
        ]);
    }
}
