<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;


use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('telephone', TextType::class, [
                'required' => false,
                'label' => 'Your phone number',
                'attr' => []
            ])
            ->add('prenom', TextType::class, [
                'required' => true,
                'constraints' => [new Assert\Length(min: 2, minMessage: "Your firstname must at least contain {{ limit }} characters")],
                'constraints' => [new Assert\Length(max: 30, maxMessage: "Your firstname must must at most contain {{ limit }} characters")],
                'label' => 'Your firstname',
                'attr' => []
            ])
            ->add('nom', TextType::class, [
                'required' => true,
                'constraints' => [new Assert\Length(min: 2, minMessage: "Your lastname must at least contain {{ limit }} characters")],
                'constraints' => [new Assert\Length(max: 30, maxMessage: "Your lastname must must at most contain {{ limit }} characters")],
                'label' => 'Your lastname',
                'attr' => []
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => "Passwords must be the same",
                'constraints' => [new Assert\Length(min: 6, minMessage: "The password must at least contain {{ limit }} characters")],
                'constraints' => [new Assert\Length(max: 100, maxMessage: "The password must at most contain {{ limit }} characters")],
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => "Password"],
                'second_options' => ['label' => "Password confirmation"]
            ])
            ->add('adresse', TextType::class, [
                'required' => true,
                'label' => 'Your adresse',
                'attr' => []
            ])
            ->add('ville', TextType::class, [
                'required' => true,
                'label' => 'City',
                'attr' => []
            ])
            ->add('codePostal', TextType::class, [
                'required' => true,
                'constraints' => [new Assert\Length(min: 6, minMessage: "The name of the city must at least contain {{ limit }} characters")],
                'constraints' => [new Assert\Length(max: 30, minMessage: "The name of the city must at most contain {{ limit }} characters")],
                'label' => 'Postal code',
                'attr' => []
            ])
            ->add('province', ChoiceType::class, [
                'required' => true,
                'label' => 'Province',
                'attr' => [],
                'choices'  => [
                    'Newfoundland and Labrador' => "NL",
                    'Prince Edward Island' => "PE",
                    'Nova Scotia' => "NS",
                    'New Brunswick' => "NB",
                    'Quebec' => "QC",
                    'Ontario' => "ON",
                    'Manitoba' => "MB",
                    'Saskatchewan' => "SK",
                    'Alberta' => "AB",
                    'British Columbia' => "BC",
                    'Yukon' => "YT",
                    'Northwest Territories' => "NT",
                    'Nunavut' => "NU"
                ],
            ])
            ->add('create', SubmitType::class, [
                'label' => "Create your account",
                'row_attr' => ['class' => 'form-button text-center mt-2'],
                'attr' => ['class' => 'btnCreate btn-success']

            ]);
        $builder->get('telephone')->addModelTransformer(new CallbackTransformer(
            function ($phoneFromDatabase) {
                $newPhone = substr_replace($phoneFromDatabase, "-", 3, 0);
                return substr_replace($newPhone, "-", 7, 0);
            },
            function ($phoneFromView) {
                return str_replace("-", "", $phoneFromView);
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
