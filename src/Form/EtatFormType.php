<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtatFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etat', ChoiceType::class, [
                'label' => 'State of the command',
                'choices' => [
                    'In preparation' => 'In preparation',
                    'Sent' => 'Sent',
                    'In transit' => 'In transit',
                    'Delivered' => 'Delivered'
                ],
                'attr' => [
                    'onchange' => 'onEtatChanger()',
                    'class' => 'form-select',
                ],
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
            'attr' => ['id' => 'formEtat']
        ]);
    }
}
