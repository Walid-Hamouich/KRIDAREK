<?php

namespace App\Form\Type;

use App\Enum\RoleEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddUserAccountType extends AbstractType
{
    function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'empty_data' => ''
            ])
            ->add('lastName', TextType::class, [
                'empty_data' => ''
            ])
            ->add('email', EmailType::class, [
                'empty_data' => ''
            ])
            ->add('password', PasswordType::class, [
                'empty_data' => ''
            ])
            ->add('phoneNum', TelType::class, [
                'empty_data' => ''
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Member' => RoleEnum::MEMBER->value,
                    'Admin' => RoleEnum::ADMIN->value,
                ],
                'invalid_message' => 'Le choix selecté n\'est pas valide.',
                'empty_data' => ''
            ])
            ->add('blackListed', CheckboxType::class, [
                'required' => false,
            ])
            ->add('save', SubmitType::class);

        //roles field data transformer
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray) ? $rolesArray[0] : null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
    }

    function configureOptions(OptionsResolver $resolver)
    {
    }
}
