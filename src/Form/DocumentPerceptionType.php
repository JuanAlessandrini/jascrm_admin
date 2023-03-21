<?php

namespace App\Form;

use App\Entity\DocumentPercepcion;
use App\Entity\SubCuenta;
use App\Repository\SubCuentaRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DocumentPerceptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('type',EntityType::class, [
                'class'=>SubCuenta::class,
                'choice_label'=>'name',
                'query_builder' => function (SubCuentaRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.tipo = :tipo')
                        ->orderBy('u.name', 'ASC')
                        ->setParameter('tipo', 'Percepcion');
                },
                'attr'=>['class'=>'form-control  js-choice-cuenta'], 'label'=>'Concepto'])
                ->add('ammount', NumberType::class, ['attr'=>['class'=>'form-control style-title suma-total number'], 'label'=>'Monto'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DocumentPercepcion::class,
        ]);
    }
}
