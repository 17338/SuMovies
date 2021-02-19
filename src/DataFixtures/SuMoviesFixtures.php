<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Films;

class SuMoviesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i = 1; $i <= 10; $i++){
            $film = new Films();
            $film->setTitle("Titre de l'article n°$i")
                ->setSynopsys("<div>Dom Cobb est un voleur expérimenté dans l'art périlleux de `l'extraction' : 
                sa spécialité consiste à s'approprier les secrets les plus précieux  d'un individu, enfouis au 
                plus profond de son subconscient, pendant qu'il rêve et que son esprit est particulièrement 
                vulnérable. Très recherché pour ses talents dans l'univers trouble de l'espionnage industriel, 
                Cobb est aussi devenu un fugitif traqué dans le monde entier. Cependant, une ultime mission 
                pourrait lui permettre de retrouver sa vie d'avant.</div>")
                ->setImage("https://via.placeholder.com/350")
                ->setGenre("Action")
                ->setCreatedAt(new \DateTime())
                ->setDuree(new \DateTime())
                ->setResume("resume de l'article n°$i");

                $manager->persist($film);
        }


        $manager->flush();
    }
}
