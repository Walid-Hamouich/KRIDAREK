<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserAccountType extends AbstractType
{
    public function getParent(): string
    {
        return AddUserAccountType::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('password');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', User::class);
    }
}
