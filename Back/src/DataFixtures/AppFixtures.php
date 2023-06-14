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
            "pop"
        ];

        $stylesImage = [
            "https://images7.alphacoders.com/436/436860.jpg", 
            "https://www.shutterstock.com/image-vector/vector-logo-rap-music-hand-260nw-1365427319.jpg", 
            "https://images.unsplash.com/photo-1470225620780-dba8ba36b745?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8ZWxlY3RybyUyMG11c2ljfGVufDB8fDB8fHww&w=1000&q=80", 
            "https://i.scdn.co/image/ab67706c0000bebbed4f4edd01cfb81857eff52d", 
            "https://media.istockphoto.com/id/1131760814/fr/photo/femme-effectuant-sur-un-violon.jpg?s=612x612&w=0&k=20&c=rBMuY9ldE5fuqPP5SFozjMm3I4rv0YMS-zr5--VMeuQ=", 
            "https://toutelaculture.com/wp-content/uploads/2013/06/decoratzia.com_-600x600.jpg"
        ];

        /** @var Style[] $allStyle */
        $allStyle = [];

        for($i=0 ; $i < count($styles); $i++){

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
            "Vinyl"
        ];

        /** @var Support $allSupport */
        $allSupport = [];

        foreach ($support as $supportName) {
            
            $newSupport = new Support();

            $newSupport->setName($supportName);
            
            $manager->persist($newSupport);

            $allSupport[]=$newSupport;
        }

        // =======================================================
        // TODO : make ARTIST (10 Artists)
        // =======================================================

        // $artistName = [
        //     "Pink Floyd", 
            
        // ];

        /** @var Artist $allArtist */
        $allArtist = [];

        for ($i=0; $i < 20 ; $i+1) {
            $newArtist = new Artist();
            $newArtist->setFullname("Artiste $i");

            $manager->persist($newArtist);

            $allArtist[] = $newArtist;
        }

        // =======================================================
        // TODO : make ALBUM (10 albums)
        // =======================================================

        // $albumName =[
        //     "The Dark Side of the Moon"
            
        // ];

        // $albumEdition = [
        //     "Harvest"

        // ];
        // $albumRelease = [
        //     "1973-03-24",

        // ];
        // $albumImage = [
        //     "https://media.senscritique.com/media/000004795486/300/the_dark_side_of_the_moon.jpg", 

        // ];

        /** @var Album $allAlbum */
        $allAlbum = [];

        for($i=0; $i < 10 ; $i++){
            $newAlbum = new Album();

            $newAlbum->setName("album $i");
            $newAlbum->setEdition("edition $i");
            $newAlbum->setReleaseDate(new DateTime("2000-01-01"));
            $newAlbum->setCreatedAt(new DateTime("now"));
            $newAlbum->setImage("https://d1csarkz8obe9u.cloudfront.net/posterpreviews/opening-soon%2C-coming-soon-design-template-2ad6ecb3bfc0d528a9999c00a642d447_screen.jpg?ts=1593776133");

            $manager->persist($newAlbum);

            $allAlbum[] = $newAlbum;
        }

        // =======================================================
        // TODO : make SONG (50 songs)
        // =======================================================

        /** @var Song $allSong */
        $allsong = [];

        for ($i=0; $i < 50 ; $i++) { 
            $newSong = new Song();

            $newSong->setTitle("title $i");
            $newSong->setDuration(30000);
            $newSong->setTrackNb(1);
            
            $manager->persist($newSong);
        }

        // =======================================================
        // TODO : ............
        // =======================================================



        // =======================================================
        // TODO : ............
        // =======================================================

        $manager->flush();
    }
}
