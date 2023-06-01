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
            ->add('name', TextType::class, ['attr'=>['class'=>'form-control', 'required'=>'required'], 'label'=>'Razon Social', 'required'=>'required'])
            ->add('cuit', TextType::class, ['attr'=>['class'=>'form-control numeric', 'required'=>'required','max-length'=>'13','data-mask'=>'##-########-#'],'label'=>'CUIT'])
            ->add('address', TextType::class, ['attr'=>['class'=>'form-control', 'required'=>'required'], 'label'=>'Domicilio'])
            ->add('city', TextType::class, ['attr'=>['class'=>'form-control', 'required'=>'required'], 'label'=>'Ciudad'])
            ->add('provincia', TextType::class, ['attr'=>['class'=>'form-control', 'required'=>'required'], 'label'=>'Provincia'])
            ->add('phone', TextType::class, ['attr'=>['class'=>'form-control', 'required'=>'required'], 'label'=>'Telefono'])
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
