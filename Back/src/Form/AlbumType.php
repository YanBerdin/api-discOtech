<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Song;
use App\Entity\Style;
use App\Entity\Support;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;


class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom de l'album :",
                "attr" => ["placeholder" => "Nevermind, fantom..."]
            ])

            ->add('songs', CollectionType::class, [
                'by_reference' => false,
                "entry_type" => SongType::class,
                "entry_options" => ['label' => false],
                'allow_add' => true,
                "label" => false,
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
                'constraints' => array(
                    new Count(array(
                        'min' => 1,
                        'minMessage' => "Ces champs ne peuvent pas être vide"
                    ))
                 ),
                "label" => "Style :",
                "multiple" => true,
                "expanded" => true, 
                "class" => Style::class,
                'choice_label' => 'name',
                "query_builder" => function(EntityRepository $entityrepository){
                    return $entityrepository->createQueryBuilder('style')
                        ->orderBy('style.name', 'ASC');
                    }
            ])

            ->add('support', EntityType::class, [
                'constraints' => array(
                    new Count(array(
                        'min' => 1,
                        'minMessage' => "Ces champs ne peuvent pas être vide"
                    ))
                 ),
                "label" => "Support :",
                "multiple" => true,
                "expanded" => true, 
                "class" => Support::class,
                'choice_label' => 'name',
                "query_builder" => function(EntityRepository $entityrepository){
                    return $entityrepository->createQueryBuilder('support')
                        ->orderBy('support.name', 'ASC');
                    }
            ])

            ->add('artist', TextType::class, [
                "label" => "Artiste :",
                "class" => Artist::class,
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
