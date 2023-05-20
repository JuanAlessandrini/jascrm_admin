<?php

namespace App\Form;

use App\Entity\SubCuenta;
use App\Entity\Cuenta;
use App\Repository\CuentaRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class SubCuentaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['attr'=>['class'=>'form-control'], 'label'=>'Nombre'])
            ->add('cuenta',EntityType::class, [
                'class'=>Cuenta::class,
                'choice_label'=>'name',
                'query_builder' => function (CuentaRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'attr'=>['class'=>'form-control  js-choice-select'], 'label'=>'Cuenta'])
            ->add('tipo', ChoiceType::class, ['choices'=>[
                'Concepto'=>'Concepto',
                'Impuesto'=>'Impuesto',
                'Percepcion'=>'Percepcion',
                'Producto'=>'Producto',
                'Retencion'=>'Retencion',
            ],'attr'=>['class'=>'form-control  js-choice-select'], 'label'=>'Tipo'])
                ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SubCuenta::class,
        ]);
    }
}
