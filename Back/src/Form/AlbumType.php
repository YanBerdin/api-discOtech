<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Style;
use App\Entity\Support;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom de l'album :",
                "attr" => ["placeholder" => "Nevermind, fantom..."]
            ])

            ->add('edition', TextType::class, [
                "label" => "Edition :",
                "attr" => ["placeholder" => "Warner, Polydor, Sony..."]
            ])

            ->add('releaseDate', DateType::class, [
                "label" => "Date de création :",
                "widget" => "single_text",
                "input" => "datetime"
                
            ])

            ->add('image', TextType::class, [
                "label" => "Pochette de l'album :",
                "attr" => ["placeholder" => "www.google.com/url?sa=i&url=https%3A%2F%2Ftwitter.com%2FOclock_io&"]
            ])


            ->add('style', EntityType::class, [
                'constraints' => [new NotBlank()],
                "label" => "Style :",
                "multiple" => true,
                "expanded" => true, 
                "class" => Style::class,
                'choice_label' => 'name'
            ])

            ->add('support', EntityType::class, [
                "label" => "Support :",
                "multiple" => true,
                "expanded" => true, 
                "class" => Support::class,
                'choice_label' => 'name'
            ])
            ->add('artist', EntityType::class, [
                "label" => "Date de création :",
                "multiple" => false,
                "expanded" => false, 
                "class" => Artist::class,
                'choice_label' => 'fullname'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
            "attr" => ["novalidate" => 'novalidate']
        ]);
    }
}
