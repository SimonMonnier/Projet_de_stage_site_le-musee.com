<?php

namespace App\DataFixtures;

use App\Entity\Voiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Entity\Image;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $fakercar = \Faker\Factory::create();
        $fakercar->addProvider(new \Faker\Provider\Fakecar($fakercar));
        $faker = \Faker\Factory::create();

        for($i = 1; $i <= 30; $i++)
        {

            $fakercar = \Faker\Factory::create();
            $fakercar->addProvider(new \Faker\Provider\Fakecar($fakercar));
            $faker = \Faker\Factory::create();
            
            $voiture = new Voiture();

            $marque = $fakercar->vehicleBrand;
            $model = $fakercar->vehicleModel;

            $voiture->setAnnee($faker->year($max = 'now'))
                    ->setType($fakercar->vehicleType)
                    ->setCreateAt(new \DateTime())
                    ->setMarque($marque)                    
                    ->setModele($fakercar->vehicleModel)
                    ->setNumeroSerie($fakercar->vehicleRegistration)
                    ->setLongueur($faker->latitude($min = 2, $max = 5))
                    ->setLargeur($faker->latitude($min = 2, $max = 3))
                    ->setHauteur($faker->latitude($min = 1, $max = 2))
                    ->setPoidsAVide($faker->latitude($min = 800, $max = 2000))
                    ->setCarburant($fakercar->vehicleFuelType)
                    ->setKilometrage($faker->latitude($min = 100000, $max = 350000))
                    ->setCouleurCarrosserie($faker->colorName)
                    ->setCouleurInterieur($faker->colorName)
                    ->setPuissance($faker->latitude($min = 20, $max = 200))
                    ->setOrigine($faker->country)
                    ->setBoiteDeVitesse($faker->word)
                    ->setMoteurEtCylindree($faker->latitude($min = 100, $max = 500))
                    ->setCvFiscaux($faker->latitude($min = 6, $max = 150))
                    ->setConduite($faker->word)
                    ->setNombreDePlace($faker->latitude($min = 2, $max = 8))
                    ->setCarrosserie($faker->word)
                    ->setetat($faker->word)
                    ->setPrix($faker->latitude($min = 20000, $max = 200000))
                    ->setIntroduction($faker->text)
                    ->setContent($faker->text.$faker->text.$faker->text.$faker->text)
                    ->setCoverImage($faker->imageUrl(512, 384, 'transport'));

            //les annonces ont aleatoirement un nombre d'image entre deux et 5
            for($j = 1; $j <= mt_rand(2,5); $j++)
            {
                $image = new Image();

                $image->setUrl($faker->imageUrl(512, 384, 'transport'))
                        ->setCaption($faker->sentence())
                        ->setVoiture($voiture);
                        
                $manager->persist($image);
            }
            $manager->persist($voiture);
        }

        $manager->flush();
    }
}
