<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Song;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SongType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('trackNb', IntegerType::class,[
            "label" => "N° de Piste",
            "attr" => ["placeholder" => "1"],
            ])
            
            ->add('title', TextType::class, [
                "label" => "Titre de la musique:",
                "attr" => ["placeholder" => "Si Tu Te Vas"],
            ])

            ->add('duration', TimeType::class, [
                'input'  => 'timestamp',
                'widget' => 'single_text',
                'with_seconds' => true
            ])
 
            ->add('preview', TextType::class, [
                "label" => "lien Youtube, spotify, dezer, etc:",
                "attr" => ["placeholder" => "youtube.com/watch?v=rlarCLhzfoU"],
            ])

            ->add('album', EntityType::class, [
                "multiple" => false,
                "expanded" => false, // dropdown
                "class" => Album::class,
                "choice_label" => "name",
                "query_builder" => function(EntityRepository $entityrepository){
                    return $entityrepository->createQueryBuilder('a')
                        ->orderBy('a.name', 'ASC');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Song::class,
            "attr" => ["novalidate" => 'novalidate']
        ]);
    }
}
