<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('lastname', TextType::class, [
            "label" => "Nom:",
            "attr" => [
                "placeholder" => "Nom ..."],
        ])

        ->add('firstname', TextType::class, [
            "label" => "Prénom:",
            "attr" => ["placeholder" => "Prénom ..."],
        ])

        ->add('email', EmailType::class,[
                "label" => "Adresse Email"
        ])

        // on utilise l'event avant de mettre les données dans le formulaire
        ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            // On récupère le form depuis l'event (pour travailler avec)
            $builder = $event->getForm();
            // On récupère le user mappé sur le form depuis l'event
            /** @var User $user */
            $user = $event->getData();

            // On conditionne le champ "password"
            // Si user existant, il a id non null
            if ($user->getId() !== null) {
                // * mode Edition
                $builder->add('password', PasswordType::class, [
                    // je ne veux pas que le formulaire mettes automatiquement à jour la valeur
                    // je désactive la mise à jour automatique de mon objet par le formulaire
                    // ? https://symfony.com/doc/5.4/reference/forms/types/form.html#mapped
                    "mapped" => false,
                    "label" => "le mot de passe",
                    "attr" => [                            
                        "placeholder" => "laisser vide pour ne pas modifier ..."
                    ],
                    // On déplace les contraintes de l'entité vers le form d'ajout
                    // 'constraints' => [
                    //     new Regex(
                    //         "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
                    //         "Le mot de passe doit contenir au minimum 8 caractères, une majuscule, un chiffre et un caractère spécial"
                    //     ),
                    // ],
                ]);
            } else {
                // * mode Création : New
                $builder->add('password', PasswordType::class, [
                    // En cas d'erreur du type
                    // Expected argument of type "string", "null" given at property path "password".
                    // (notamment à l'edit en cas de passage d'une valeur existante à vide)
                    'empty_data' => '',
                    // On déplace les contraintes de l'entité vers le form d'ajout
                    'constraints' => [
                        new NotBlank(),
                    //     new Regex(
                    //         "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
                    //         "Le mot de passe doit contenir au minimum 8 caractères, une majuscule, un chiffre et un caractère spécial"
                    //     ),
                    ],
                ]);
            }
        })

        ->add('roles', ChoiceType::class, [
            "multiple" => true,
            "expanded" => true,
            "choices" => [
                "ADMIN" => "ROLE_ADMIN",
                "USER" => "ROLE_USER",
            ],
        ])
            
        //TODO Why out an Image?
        ->add('avatar', TextType::class, [
            "label" => "Photo de profil",
            "attr" => ["placeholder" => "www.google.com/url?sa=i&url=https%3A%2F%2Ftwitter.com%2FOclock_io&"],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            "attr" => ["novalidate" => "novalidate"]
        ]);
    }
}

