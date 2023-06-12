<?php

namespace App\Serializer;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class DoctrineDenormalizer implements DenormalizerInterface
{

    /**
    * Instance de EntityManagerInterface
    *
    * @var EntityManagerInterface
    */
    private $entityManagerInterface;
    
    /**
    * Constructor
    */
    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManagerInterface = $entityManagerInterface;
    }
    /**
     * Appel quand on a besoin de denormaliser
     *
     * @param mixed $data : la valeur que l'on tente de denormaliser (dans notre cas un ID)
     * @param string $type : le type que l'on veut obtenir (dans notre cas un entity)
     * @param string|null $format
     */
    public function supportsDenormalization($data, string $type, ?string $format = null): bool
    {
        //? je sais traiter le cas où $data est un ID
        //? je sais traiter le cas où $type est un entity
        $dataIsID = is_numeric($data);
        // $type : App\Entity\Type,  App\Entity\Person, etc ...
        // @link https://www.php.net/manual/fr/function.strpos.php
        // je cherche dans $type (App\Entity\Type) si on trouve 'App\Entity' au début (=== 0)
        $typeIsEntity = strpos($type, 'App\Entity') === 0;

        // je réponds Oui si les DEUX sont vrai
        return $typeIsEntity && $dataIsID;
    }

    /**
     * Si je suis dans le cas où $data est un ID ET $type est un Entity
     *
     * @param mixed $data : la valeur que l'on tente de denormaliser (dans notre cas un ID)
     * @param string $type : le type que l'on veut obtenir (dans notre cas un entity)
     * @param string|null $format
     * @param array $context
     * 
     * @return mixed
     */
    public function denormalize($data, string $type, ?string $format = null, array $context = [])
    {
        //? ici on veut faire appel à Doctrine
        // pour faire un find() avec l'ID fournit
        // $type = App\Entity\Type
        // $data = 13
        $denormalizedEntity = $this->entityManagerInterface->find($type, $data);
        if ($denormalizedEntity === null)
        {
            throw new Exception($type . "#". $data ." not found");
        }
        return $denormalizedEntity;
    }
}