<?php

namespace App\Form;

use App\Entity\Documento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class DocumentoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['attr'=>['class'=>'form-control style-title'], 'label'=>'Nombre'])
            ->add('role_upload', TextType::class, [
                'attr'=>['class'=>' js-choice style-title  text-capitalize'],
             'label'=>'Quienes pueden Subir Archivos'])
            ->add('request_image', CheckboxType::class, ['attr'=>['class'=>'checkbox'], 'label'=>'Requerir Imagen','required'=>false])
            ->add('request_paper', CheckboxType::class, ['attr'=>['class'=>'checkbox'], 'label'=>'Requerir Físico','required'=>false])
            ->add('oculto', CheckboxType::class, ['attr'=>['class'=>'checkbox'], 'label'=>'Oculto','required'=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Documento::class,
        ]);
    }
}
