<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\BankAccount;
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
class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, ['attr'=>['class'=>'form-control'], 'label'=>'Razon Social'] )
            ->add('cuit',TextType::class, ['attr'=>['class'=>'form-control'], 'label'=>'CUIT'] )
            ->add('address',TextType::class, ['attr'=>['class'=>'form-control'], 'label'=>'Domicilio'] )
            ->add('city',TextType::class, ['attr'=>['class'=>'form-control'], 'label'=>'Localidad'] )
            ->add('provincia',TextType::class, ['attr'=>['class'=>'form-control'], 'label'=>'Provincia'] )
            // ->add('campanias',TextType::class, ['required'=>false,'attr'=>['class'=>'form-control'], 'label'=>'Campañas'] )
            ->add('sucursales',TextType::class, ['attr'=>['class'=>'form-control'], 'label'=>'Sucursales','required'=>false] )
            ->add('centro_costos',TextType::class, ['attr'=>['class'=>'form-control'], 'label'=>'Centros de Costos','required'=>false] )
            ->add('bankAccounts', CollectionType::class, [
                'entry_type' => BankAccountType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'label'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
