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
        $admin->setAvatar("placeholder.png");

        $manager->persist($admin);

        $user = new User();
        $user->setEmail("user@user.com");
        // * on donne le mot de passe hashé
        // mdp : user
        $user->setPassword('$2y$13$LU7xmAHYLxg9cWqkshuUHOJUBZH7vDHKA/wENstwKu8rtwyUJgBRy');
        $user->setRoles(['ROLE_USER']);
        $user->setFirstname("user");
        $user->setLastname("user");
        $user->setAvatar("placeholder.png");

        $manager->persist($user);

        // =======================================================
        // TODO : make STYLES
        // =======================================================
        $styles = [
            "Country",
            "Pop",
            "Classique", 
            "House", 
            "Rap", 
            "Rock", 
            "K-pop",
            "Funk",
            "Lofi",
            "Soul",
            "Metal",
            "Indie",
            "RnB",
            "Opera",
            "Jazz",
            "Techno", 
            "Afro",
            "Reggae",
            "Blues",
            "Dub",
            "chill",
            "Trance",
            "Latino",
        ];

        $stylesImage = [
        
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923701296058399/country.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923701757423737/pop.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923702181044394/classique2.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923703296733194/house.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923703829405778/rap3.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923705284829214/rock3.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923730488410234/kpop.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923730886864896/funk.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923731281121381/lofi2.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923731654426714/soul.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923732367446107/metal.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923733084680293/indie.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923733579599982/RnB.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923734242312243/opera2.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923739388727437/jazz.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923739745239170/techno.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923750939824138/afro2.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923751866773559/reggae.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923752277807237/blues_2.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923753125064795/dub.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923753594818590/chill.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923753976496218/trance.png",
            "https://cdn.discordapp.com/attachments/1113101484519866380/1118923754744057908/latino.png",

        ];

        /** @var Style[] $allStyle */
        $allStyle = [];

        for($i=0 ; $i < count($styles)-1; $i++){

            $newStyle = new Style();

            $newStyle->setName($styles[$i]);
            $newStyle->setImage($stylesImage[$i]);

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
                    $newSong->setDuration(mt_rand(120, 520));
                    $newSong->setTrackNb($j);

                    $newSong->setAlbum($allAlbum[mt_rand(0,count($allAlbum)-1)]);

                    $manager->persist($newSong);


                    $allSong[] = $newSong;
                }

            }
        
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
        // TODO : Associate ALBUM with 1 or 3 SUPPORT
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


