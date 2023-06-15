<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Song;
use App\Entity\Style;
use App\Entity\Support;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    /**
     * Create Data
     *
     * @param ObjectManager $manager Equivalent à l'EntityManager
     */
    public function load(ObjectManager $manager): void
    {

        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Bluemmb\Faker\PicsumPhotosProvider($faker));

        // =======================================================
        // TODO : Make 2 users (ADMIN + USER profile)
        // =======================================================
        $admin = new User();
        $admin->setEmail("admin@admin.com");
        // * on donne le mot de passe hashé
        // mdp : admin
        $admin->setPassword('$2y$13$ZdKTqUsVIggw9REUVSBTn.nwh.YjS8TKqlTme3sTi96HhziHxOfhO');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setFirstname("admin");
        $admin->setLastname("admin");
        $admin->setAvatar("");

        $manager->persist($admin);

        $user = new User();
        $user->setEmail("user@user.com");
        // * on donne le mot de passe hashé
        // mdp : user
        $user->setPassword('$2y$13$LU7xmAHYLxg9cWqkshuUHOJUBZH7vDHKA/wENstwKu8rtwyUJgBRy');
        $user->setRoles(['ROLE_USER']);
        $user->setFirstname("user");
        $user->setLastname("user");
        $user->setAvatar("");

        $manager->persist($user);

        // =======================================================
        // TODO : make STYLES
        // =======================================================
        $styles = [
            "Rock", 
            "Rap", 
            "Electro", 
            "House", 
            "Classique", 
            "Pop",
            "Latino",
            "Techno",
            "Trance",
            "chill",
            "Dub",
            "Blues",
            "Jazz",
            "Afro",
            "Opera",
            "Indie",
            "RnB",
            "Country",
            "Punk",
            "Reggae",
            "Metal",
            "Soul",
            "Funk",
            "K-pop"
        ];

        $stylesImage = [
            "https://www.wplounge.nl/wp-content/uploads/2014/03/coming-soon.png", 
     

        ];

        /** @var Style[] $allStyle */
        $allStyle = [];

        for($i=0 ; $i < count($styles)-1; $i++){

            $newStyle = new Style();

            $newStyle->setName($styles[$i]);
            $newStyle->setImage($stylesImage[0]);

            $manager->persist($newStyle);

            $allStyle[]= $newStyle;
        }

        // =======================================================
        // TODO : make SUPPORT
        // =======================================================
        $support = [
            "CD", 
            "Cassette", 
            "Vinyl 33 tours",
            "Vinyl 45 tours"
        ];

        /** @var Support[] $allSupport */
        $allSupport = [];

        foreach ($support as $supportName) {
            
            $newSupport = new Support();

            $newSupport->setName($supportName);
            
            $manager->persist($newSupport);

            $allSupport[]=$newSupport;
        }

        // =======================================================
        // TODO : make ARTIST (200 Artists)
        // =======================================================

        /** @var Artist[] $allArtist */
        $allArtist = [];

        for ($i=0; $i < 200 ; $i++) {
            $newArtist = new Artist();

            $newArtist->setFullname($faker->name());

            $manager->persist($newArtist);

            $allArtist[] = $newArtist;
        }

        // =======================================================
        // TODO : make ALBUM (200 albums)
        // =======================================================

        /** @var Album[] $allAlbum */
        $allAlbum = [];

        for($i=0; $i < 200 ; $i++){
            $newAlbum = new Album();

            $newAlbum->setName($faker->sentence(3));
            $newAlbum->setEdition($faker->sentence(1));
            $newAlbum->setReleaseDate(new DateTime($faker->date("Y-m-d")));
            $newAlbum->setCreatedAt(new DateTime("now"));
            $newAlbum->setImage($faker->imageUrl(500,500,true));

            $newAlbum->setArtist($allArtist[mt_rand(0,count($allArtist)-1)]);



            $manager->persist($newAlbum);

            $allAlbum[] = $newAlbum;
        }

        // =======================================================
        // TODO : make SONG (2000 songs)
        // =======================================================

        /** @var Song[] $allSong */
        $allSong = [];

            for ($i=1; $i <= 200 ; $i++) {
                for ($j=1; $j <= 10; $j++) {
                    $newSong = new Song();

                    $newSong->setTitle($faker->sentence(4,true));
                    $newSong->setDuration($faker->numberBetween(180000, 300000));
                    $newSong->setTrackNb($j);

                    $newSong->setAlbum($allAlbum[mt_rand(0,count($allAlbum)-1)]);

                    $manager->persist($newSong);


                    $allSong[] = $newSong;
                }

            }

        // =======================================================
        // TODO : Associate ALBUM with ARTIST
        // =======================================================

        // foreach ($allArtist as $artist)
        // {
        //     $randomAlbum = $allAlbum[mt_rand(0,count($allAlbum)-1)];
        //     $artist->addAlbum($randomAlbum);
        // }
            
        // =======================================================
        // TODO : Associate 1 ALBUM with 10 SONG
        // =======================================================

        // foreach ($allAlbum as $album)
        // {
        //     for ($i=0 ; $i <10 ; $i++)
        //     {
        //         $randomSong = $allSong[mt_rand(0,count($allSong)-1)];
        //         $album->addSong($randomSong);
        //     }
        // }
        
        // =======================================================
        // TODO : Associate ALBUM with STYLE
        // =======================================================

        foreach ($allAlbum as $album)
        {
            $randomNbStyle = mt_rand(1,3);
            for ($i=0; $i <= $randomNbStyle; $i++) {

                $randomStyle = $allStyle[mt_rand(0, count($allStyle)-1)];
                $album->addStyle($randomStyle);
            }
        }

        // =======================================================
        // TODO : Associate ALBUM with 1 or 2 SUPPORT
        // =======================================================

        foreach ($allAlbum as $album)
        {
            $randomNbSupport = mt_rand(1,3);
            for ($i=0; $i <= $randomNbSupport; $i++) {
                $randomSupport = $allSupport[mt_rand(0, count($allSupport)-1)];
                $album->addSupport($randomSupport);
            }
        }

        $manager->flush();
    }
}
