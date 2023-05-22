<?php

namespace App\Form;

use App\Entity\Vendor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class VendorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['attr'=>['class'=>'form-control style-title text-uppercase'], 'label'=>'Razon Social'])
            ->add('cuit', NumberType::class, ['attr'=>['maxlength'=>'13', 'pattern'=>'\d{2}\-\d{8}\-\d{1}', 'data-mask'=>'99-99999999-9','class'=>'form-control style-title text-uppercase'], 'label'=>'CUIT'])
            ->add('address', TextType::class, ['attr'=>['class'=>'form-control style-title text-uppercase'], 'label'=>'Domicilio'])
            ->add('city', TextType::class, ['attr'=>['class'=>'form-control style-title text-uppercase'], 'label'=>'Ciudad'])
            ->add('condicion_impositiva', ChoiceType::class, ['choices'=>[
                'Responsable Inscripto'=>'Responsable Inscripto',
                'Responsable Monotributo'=>'Responsable Monotributo',
                'Exento'=>'Exento',
                'No inscripto'=>'No inscripto'
            ],'attr'=>['class'=>'form-control  js-choice-select'], 'label'=>'Cond. Impositiva'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vendor::class,
        ]);
    }
}
