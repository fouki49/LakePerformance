<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints as Assert;

class PasswordModificationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'mapped' => false,
                'constraints' => [new UserPassword(["message" => "New Passwords must be the same as the old one"])]
            ])
            ->add('newPassword', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => "New Passwords must be the same",
                'constraints' => [new Assert\Length(min: 6, minMessage: "The password must at least contain {{ limit }} characters")],
                'constraints' => [new Assert\Length(max: 100, maxMessage: "The password must at most contain {{ limit }} characters")],
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => "New Password"],
                'second_options' => ['label' => "New Password confirmation"],
            ])
            ->add('update', SubmitType::class, [
                'label' => "Modify your password",
                'row_attr' => ['class' => 'form-button text-center mt-2'],
                'attr' => ['class' => 'btnCreate btn-success']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
