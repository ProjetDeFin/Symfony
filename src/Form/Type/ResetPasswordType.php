<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

final class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'New Password'],
                'second_options' => ['label' => 'Confirm New Password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Password should not be blank',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern' => '/[A-Z]/',
                        'message' => 'Your password must contain at least one uppercase letter',
                    ]),
                    new Regex([
                        'pattern' => '/[a-z]/',
                        'message' => 'Your password must contain at least one lowercase letter',
                    ]),
                    new Regex([
                        'pattern' => '/\d/',
                        'message' => 'Your password must contain at least one number',
                    ]),
                    new Regex([
                        'pattern' => '/[\W_]/',
                        'message' => 'Your password must contain at least one special character',
                    ]),
                ],
            ])
            ->add('token', HiddenType::class, ['data' => $options['token']])
            ->add('submit', SubmitType::class, [
                'label' => 'Reset Password',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('token', null);
    }
}
