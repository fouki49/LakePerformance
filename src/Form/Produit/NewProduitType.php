<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints as Assert;


class NewProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('idCategorie', EntityType::class, [
            'class' => Categorie::class,
            'label' => 'Category',
            'choice_label' => 'categorie'
        ])
            ->add('nom', TextType::class, [
                'label' => 'Product name',
                'constraints' => [new Assert\Length(min: 4, minMessage: "The name of the product must at least contain {{ limit }} characters")],
                'constraints' => [new Assert\Length(max: 30, maxMessage: "The name of the product must at most contain {{ limit }} characters")],
                'required' => true
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prices',
                'required' => true
            ])
            ->add('quantiteEnStock', NumberType::class, [
                'label' => 'In Stock',
                'required' => true
            ])
            ->add('imagePath', FileType::class, [
                'label' => 'Product image',
                'data_class' => null,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg'
                        ],
                        'mimeTypesMessage' => 'Téléverser une image valide.'
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Product description',
                'required' => false,
                
            ])
            ->add('btnSave', SubmitType::class, [
                'row_attr' => ['class' => 'form-button col-3'],
                'attr' => ['class' => 'btnSave btn btn-success w-100']
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
