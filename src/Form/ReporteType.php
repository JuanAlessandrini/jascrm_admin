<?php

namespace App\Form;

use App\Entity\Reporte;
use App\Entity\SubCuenta;
use App\Entity\EntidadTypeDoc;
use App\Entity\EntidadField;
use App\Repository\SubCuentaRepository;
use App\Repository\EntidadTypeDocRepository;
use App\Repository\EntidadFieldRepository;
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

class ReporteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('template', ChoiceType::class, ['attr'=>['class'=>'form-control style-title text-uppercase'],
            'choices' => [
                'Agrupa Concepto'=>'view_group1','Encolumna Concepto'=>'view']
             , 'label'=>'Tempalte'])
            ->add('conceptos',EntityType::class, [
                'class'=>SubCuenta::class,
                'multiple'=>true,
                'choice_label'=>'name',
                'query_builder' => function (SubCuentaRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'required'=>false,
                'attr'=>['class'=>'form-control  js-choice-select'], 'label'=>'Conceptos'])
            ->add('tipos',EntityType::class, [
                'class'=>EntidadTypeDoc::class,
                'multiple'=>true,
                'choice_label'=>'name',
                'required'=>false,
                'query_builder' => function (EntidadTypeDocRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'attr'=>['class'=>'form-control  js-choice-select'], 'label'=>'Tipos de Doc'])
            ->add('campos',EntityType::class, [
                'class'=>EntidadField::class,
                'multiple'=>true,
                'choice_label'=>'name',
                'required'=>false,
                'query_builder' => function (EntidadFieldRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'attr'=>['class'=>'form-control  js-choice-select'], 'label'=>'Campos'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reporte::class,
        ]);
    }
}
