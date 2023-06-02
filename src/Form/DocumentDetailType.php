<?php

namespace App\Form;

use App\Entity\DocumentDetail;
use App\Entity\SubCuenta;
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

class DocumentDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('concepto',EntityType::class, [
                'class'=>SubCuenta::class,
                'choice_label'=>'name',
                'query_builder' => function (SubCuentaRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->join('u.cuenta', 'c')
                        ->andWhere('u.tipo = :tipo')
                        ->andWhere('c.name <> :caja')
                        ->orderBy('u.name', 'ASC')
                        ->setParameter('tipo', 'Concepto')
                        ->setParameter('caja', 'Caja y Bancos');
                },
                'attr'=>['class'=>'form-control  js-choice-cuenta'], 'label'=>'Concepto'])
                ->add('cantidad', NumberType::class, ['attr'=>['class'=>'form-control suma-subtotal-cant '], 'label'=>'Cantidad'])
                ->add('precio_unitario', NumberType::class, ['attr'=>['class'=>'form-control suma-subtotal-pu '], 'label'=>'Precio Unitario'])
                ->add('ammount', NumberType::class, ['attr'=>['class'=>'form-control suma-total '], 'label'=>'Monto'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DocumentDetail::class,
        ]);
    }
}
