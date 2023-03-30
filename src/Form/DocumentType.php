<?php

namespace App\Form;

use App\Entity\Document;
use App\Entity\Customer;
use App\Entity\Vendor;
use App\Entity\SubCuenta;
use App\Entity\Cheque;
use App\Entity\Grano;
use App\Entity\BankAccount;
use App\Repository\VendorRepository;
use App\Repository\CustomerRepository;
use App\Repository\GranoRepository;
use App\Repository\SubCuentaRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
       
        ->add('created_at', DateType::class, ['widget' => 'single_text','attr'=>['class'=>'form-control style-title text-uppercase'], 'label'=>'Fecha'])
            ->add('vendor',EntityType::class, [
                'class'=>Vendor::class,
                'choice_label'=>'name',
                'placeholder'=>'Seleccionar Cliente',
                'query_builder' => function (VendorRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'attr'=>['class'=>'form-control  js-choice-select'], 'label'=>'Cliente'])
            ->add('codigo', ChoiceType::class, ['attr'=>['class'=>'form-control style-title text-uppercase'], 'label'=>'Codigo'])
            ->add('emisor', NumberType::class, ['attr'=>['class'=>'form-control style-title text-uppercase'], 'label'=>'Emisor'])
            ->add('numero', NumberType::class, ['attr'=>['class'=>'form-control style-title text-uppercase'], 'label'=>'Numero'])
            ->add('subtotal', NumberType::class, ['attr'=>['class'=>'form-control style-title text-uppercase suma-total'], 'label'=>'Monto'])
            ->add('total', NumberType::class, ['attr'=>['class'=>'form-control style-title text-uppercase disabled ver-total'], 'label'=>'Total'])
            ->add('sucursal', ChoiceType::class, ['attr'=>['class'=>'form-control style-title text-uppercase'], 'label'=>'Sucursal'])
            ->add('campania', ChoiceType::class, ['attr'=>['class'=>'form-control style-title text-uppercase'],
            'choices' => [
                '2023'=>'2023','2024' =>'2024','2025'=> '2025']
             , 'label'=>'Campaña'])
            ->add('grano',EntityType::class, [
                'class'=>Grano::class,
                'choice_label'=>'name',
                'placeholder'=>'Seleccionar Grano',
                'query_builder' => function (GranoRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'attr'=>['class'=>'form-control  js-choice-select'], 'label'=>'Grano'])
            ->add('detail', CollectionType::class, [
                'entry_type' => DocumentDetailType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'label'=>false
            ])
            ->add('impuestos', CollectionType::class, [
                'entry_type' => DocumentImpuestoType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'label'=>false
            ])
            ->add('percepciones', CollectionType::class, [
                'entry_type' => DocumentPerceptionType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'label'=>false
            ])
            ->add('retenciones', CollectionType::class, [
                'entry_type' => DocumentRetencionType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'label'=>false
            ])
            ->add('concepto_caja',EntityType::class, [
                'class'=>SubCuenta::class,
                'choice_label'=>'name',
                'multiple'=>false,
                'expanded'=>false,
                'placeholder' => '',
                'empty_data' => 'Seleccionar',
                'data'=>null,
                'query_builder' => function (SubCuentaRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->join('u.cuenta', 'c')
                    ->andWhere('u.tipo = :tipo')
                    ->andWhere('c.name = :caja')
                    ->orderBy('u.name', 'ASC')
                    ->setParameter('tipo', 'Concepto')
                    ->setParameter('caja', 'Caja y Bancos');
                },
                'attr'=>['class'=>'form-control '], 'label'=>'Origen / Destino'])
            ->add('medio_pago', ChoiceType::class, ['attr'=>['class'=>'form-control'],
            'placeholder'=>'Seleccionar...',
            'choices' => [
                'Efectivo'=>'Efectivo',
                'Transferencia' =>'Transferencia',
                'Tarjeta'=> 'Tarjeta',
                'Cheque'=>'Cheque'
                ]
                , 'label'=>'Medio de Pago'])
            ->add('cheques', CollectionType::class, [
                'entry_type' => ChequeType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'label'=>false
            ])
            ;

        $formModifier = function (FormInterface $form,Document $document) {
           
                    $bancos = $document->getCustomer()->getBankAccounts();

                    $form->add('cuenta_bancaria', EntityType::class, [
                        'class' => BankAccount::class,
                        'choice_label'=>function($element){
                            return $element->getBanco()->getName()." - ". $element->getCbu();
                        },
                        'placeholder' => '',
                        'required'=>false,
                        'choices' => $bancos,
                        'attr'=>['class'=>'form-control '], 
                    ]);
            
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();

                $formModifier($event->getForm(), $data);
            }
        );

        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
        ]);
    }
}
