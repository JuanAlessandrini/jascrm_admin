<?php

namespace App\Form;

use App\Entity\Concesionaria;
use App\Entity\Tramite;
use App\Entity\TipoTramite;
use App\Entity\StatusTramite;
use App\Repository\TipoTramiteRepository;
use App\Repository\ConcesionariaRepository;
use App\Repository\StatusTramiteRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Form\EventListener\AddNameFieldSubscriber;


class TramiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tipo', EntityType::class, [
                'class'=>TipoTramite::class,
                'attr'=>['class'=>'text-uppercase'],
                'choice_label'=>'name',
                'query_builder' => function (TipoTramiteRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'attr'=>['class'=>'js-choice'], 'label'=>'Tipo de Trámite'])
            ->add('concesionaria', EntityType::class, [
                'class'=>Concesionaria::class,
                'choice_label'=>'razon_social',
                'query_builder' => function (ConcesionariaRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.razon_social', 'ASC');
                },
                'attr'=>['class'=>'js-choice'], 'label'=>'Concesionaria'])
            ->add('sucursal', ChoiceType::class)
            ->add('status', EntityType::class, [
                'class'=>StatusTramite::class,
                'choice_label'=>'name',
                'query_builder' => function (StatusTramiteRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'attr'=>['class'=>'js-choice'], 'label'=>'Estado'])

            ;

            $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $tramite = $event->getData();
                $form = $event->getForm();
        
                
                if ($tramite && null !== $tramite->getId()) {
                    
                    $form->add('sucursal', ChoiceType::class, ['choices'=>[
                            $tramite->getSucursal()=>$tramite->getSucursal()
                        ],
                       
                    ])
                    ->add('tipo', EntityType::class, [
                        'attr'=>['class'=>'js-choice text-uppercase disabled', 'data-error'=>'Completar Tipo de Tramite'],
                        
                        'class'=>TipoTramite::class,
                        'choice_label'=>'name',
                        'query_builder' => function (TipoTramiteRepository $er) {
                            return $er->createQueryBuilder('u')
                                ->orderBy('u.name', 'ASC');
                        },
                         'label'=>'Tipo de Trámite'])
                    ->add('concesionaria', EntityType::class, [
                        
                        'class'=>Concesionaria::class,
                        'choice_label'=>'razon_social',
                        'query_builder' => function (ConcesionariaRepository $er) {
                            return $er->createQueryBuilder('u')
                                ->orderBy('u.razon_social', 'ASC');
                        },
                        'attr'=>['class'=>'text-uppercase js-choice  disabled'], 'label'=>'Concesionaria']);
                }
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tramite::class,
        ]);
    }

    

    
}
