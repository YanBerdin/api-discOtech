<?php

namespace App\Form;

use App\Entity\Style;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class StyleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom du Style",
                "attr" => ["placeholder" => "Rock, Rap, Punk, Electro"],
            ])

            ->add('image', TextType::class, [
                "label" => "lien de l'image",
                "attr" => ["placeholder" => "www.google.com/url?sa=i&url=https%3A%2F%2Ftwitter.com%2FOclock_io&"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Style::class,
            "attr" => ["novalidate" => 'novalidate']
        ]);
    }
}
