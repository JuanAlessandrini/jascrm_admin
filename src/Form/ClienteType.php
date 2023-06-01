<?php

namespace App\Form;

use App\Entity\Cliente;
use App\Entity\Province;
use App\Repository\ProvinceRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;




class ClienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['attr'=>['class'=>'form-control'], 'label'=>'Nombre'])
            ->add('province', EntityType::class, [
                'class'=>Province::class,
                'choice_label'=>'name',
                'query_builder' => function (ProvinceRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'attr'=>['class'=>'form-control  js-choice-select'], 'label'=>'Provincia'])
            ->add('city', TextType::class, ['attr'=>['class'=>'form-control'], 'label'=>'Ciudad'])
            ->add('address', TextType::class, ['attr'=>['class'=>'form-control'], 'label'=>'Domicilio'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cliente::class,
        ]);
    }
}
