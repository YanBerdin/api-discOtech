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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class UserEditType extends AbstractType
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

            ->add('email', EmailType::class, [
                "label" => "Identification par Email"

                ])
                ->add('password', PasswordType::class, [
                    // je ne veux pas que le formulaire mettes automatiquement à jour la valeur
                    // je désactive la mise à jour automatique de mon objet par le formulaire
                    "mapped" => false,
                    "label" => "le mot de passe",
                    "attr" => [
                        "placeholder" => "laisser vide pour ne pas modifier ..."
                    ],
                    // On déplace les contraintes de l'entité vers le form d'ajout
                    'constraints' => [
                        new Regex(
                            "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
                            "Le mot de passe doit contenir au minimum 8 caractères, une majuscule, un chiffre et un caractère spécial"
                        ),
                    ],
                ])
                
            ->add('roles', ChoiceType::class, [
                "mapped" => false,
                "expanded" => false,
                "multiple" => false,
                "choices" => [
                    "ADMIN" => "ROLE_ADMIN",
                    "USER" => "ROLE_USER",
                    "query_builder" => function(EntityRepository $entityrepository){
                        return $entityrepository->createQueryBuilder('user')
                            ->orderBy('user.role', 'ASC');
                        }
                ]
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
