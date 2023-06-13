<?php

namespace app\service;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

// class PictureService{
//     private $params;

//     public function ___construct(ParameterBagInterface $params)

//     {
//         $this->params = $params;
//     }

//     public function add(UploadedFile $picture, ?string $folder ='', ?int $width = 700, ?int $height = 700)
//     {
//         //rename picture
//         $fichier = md5(uniqid(rand(), true)) . '.jpeg';

//         //on recupere les info de l'image
//         $pictureInfo = getimagesize($picture);
//         if ($pictureInfo === false) {
//             throw new Exception("Le format de l'image est incorrect");  
//         }

//         //verification du format de l'image
//         switch($pictureInfo['mine']){
//             case 'image/png':
//                 $pictureSource = imagecreatefrompng($picture); 
//                 break;
//             case 'image/jepg':
//                 $pictureSource = imagecreatefromjpeg($picture);
//                 break;
//             case 'image/webp':
//                 $pictureSource = imagecreatefromwebp($picture);
//                 break;
//             default:
//             throw new Exception("Le format de l'image est incorrect");
//         }
//         //on recadre l'image
//         //on recupere les dimention
//         $imageWidth = $pictureInfo [0];
//         $imageHeight = $pictureInfo [1];

//         //On verifie l'orientation de l'image
//         switch ($imageWidth<=>$imageHeight) {
//             case -1: //portait
//                 $squareSize = $imageWidth;
//                 $src_x = 0;
//                 $src_y = 0;
//                 break;
//             case 0: //carré
//                 $squareSize = $imageWidth;
//                 $src_x = 0;
//                 $src_y = ($imageHeight - $squareSize) / 2;
//             case 1: //paysage
//                 $squareSize = $imageHeight;
//                 $src_x = ($imageHeight - $squareSize) / 2;
//                 $src_y = 0;
//             default:
//                 # code...
//                 break;
//         }
//     }
// }
