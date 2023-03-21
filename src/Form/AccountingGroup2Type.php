<?php

namespace App\Form;

use App\Entity\AccountingGroup2;
use App\Entity\AccountingGroup1;
use App\Repository\AccountingGroup1Repository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AccountingGroup2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('group1',EntityType::class, [
                'class'=>AccountingGroup1::class,
                'choice_label'=>'name',
                'query_builder' => function (AccountingGroup1Repository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'attr'=>['class'=>'form-control  js-choice-select'], 'label'=>'Tipo'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AccountingGroup2::class,
        ]);
    }
}
