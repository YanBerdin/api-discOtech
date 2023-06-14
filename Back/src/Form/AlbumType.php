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
                "label" => "Nom de l'album:",
                "attr" => ["placeholder" => "Nevermind, fantom..."],
                "constraints" => [new NotBlank()]
            ])

            ->add('edition', TextType::class, [
                "constraints" => [new NotBlank()],
                "label" => "Edition:",
                "attr" => ["placeholder" => "Warner, Polydor, Sony..."],
                "constraints" => [new NotBlank()]
            ])

            ->add('releaseDate', DateType::class, [
                "widget" => "single_text",
                "input" => "datetime",
                "constraints" => [new NotBlank()]
                
            ])

            ->add('image', TextType::class, [
                "label" => "lien de l'image",
                "attr" => ["placeholder" => "www.google.com/url?sa=i&url=https%3A%2F%2Ftwitter.com%2FOclock_io&"]
            ])


            ->add('style', EntityType::class, [
               
                "multiple" => true,
                "expanded" => false, 
                "class" => Style::class,
                'choice_label' => 'name',
                "constraints" => [new NotBlank()]
            ])

            ->add('support', EntityType::class, [
                
                "multiple" => true,
                "expanded" => false, 
                "class" => Support::class,
                'choice_label' => 'name',
                "constraints" => [new NotBlank()],
            ])

            ->add('artist', EntityType::class, [
                "mapped"=> false,
                "multiple" => false,
                "expanded" => false, 
                "class" => Artist::class,
                'choice_label' => 'fullname',
                "constraints" => [new NotBlank()],
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
