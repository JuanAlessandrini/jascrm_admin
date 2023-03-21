<?php

namespace App\Form;

use App\Entity\EntidadTypeDoc;
use App\Entity\Entidad;
use App\Entity\EntidadField;
use App\Repository\EntidadRepository;
use App\Repository\EntidadFieldRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EntidadTypeDocType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('code')
            ->add('signo')
            ->add('entidad',EntityType::class, [
                'class'=>Entidad::class,
                'choice_label'=>'name',
                'query_builder' => function (EntidadRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'attr'=>['class'=>'form-control  js-choice-select'], 'label'=>'Grupo'])
            ->add('fields',EntityType::class, [
                'class'=>EntidadField::class,
                'multiple'=>true,
                'choice_label'=>'name',
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
            'data_class' => EntidadTypeDoc::class,
        ]);
    }
}
