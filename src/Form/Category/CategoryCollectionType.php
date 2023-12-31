<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategoryCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categories', CollectionType::class, [
                'entry_type' => CategoryType::class,
                'allow_add' => true
            ])
            ->add('btnSave', SubmitType::class, [
                'label' => 'Save',
                'row_attr' => ['class' => 'form-button col-3'],
                'attr' => ['class' => 'btnSave btn btn-success w-100']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'category_collection_form'
        ]);
    }
}
