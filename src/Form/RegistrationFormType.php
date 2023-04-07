<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('telephone', TextType::class, [
                'required' => true,
                'label' => 'Votre numéro de téléphone',
                'attr' => []
            ])
            ->add('prenom', TextType::class, [
                'required' => true,
                'label' => 'Votre prenom',
                'attr' => []
            ])
            ->add('nom', TextType::class, [
                'required' => true,
                'label' => 'Votre nom',
                'attr' => []
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => "Les mots de passe doivent être identiques",
                // 'constraints' => [new Assert\Length(min:6, minMessage:"Le mot de passe doit contenir au moins {{ limit }} caractères")],
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => "Mot de passe"],
                'second_options' => ['label' => "Confirmation du mot de passe"]
            ])
            ->add('adresse', TextType::class, [
                'required' => true,
                'label' => 'Votre adresse',
                'attr' => []
            ])
            ->add('ville', TextType::class, [
                'required' => true,
                'label' => 'Ville',
                'attr' => []
            ])
            ->add('codePostal', TextType::class, [
                'required' => true,
                'label' => 'Code postal',
                'attr' => []
            ])
            ->add('province', TextType::class, [
                'required' => true,
                'label' => 'Province',
                'attr' => []
            ])
            ->add('create', SubmitType::class, [
                'label' => "Créer votre compte",
                'row_attr' => ['class' => 'form-button text-center mt-2'],
                'attr' => ['class' => 'btnCreate btn-success w-25']
                
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
