<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Voiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        
       $simon = new User();
       $john = new User();
       $joachim = new User();
        
       $hashsimon = $this->encoder->encodePassword($simon, 'password');
       $hashjohn = $this->encoder->encodePassword($john, 'password');
       $hashjoachim = $this->encoder->encodePassword($joachim, 'password');

       $simon->setFirstName("simon")
             ->setLastName("monnier")
             ->setHash($hashsimon)
             ->setEmail("smonnier@lemusee.fr")
             ->addUserRole($adminRole);


       $john->setFirstName("john")
            ->setLastName("guerard")
            ->setHash($hashjohn)
            ->setEmail("jguerard@lemusee.fr")
            ->addUserRole($adminRole);


       $joachim->setFirstName("joachim")
                ->setLastName("sall")
                ->setHash($hashjoachim)
                ->setEmail("jsall@lemusee.fr")
                ->addUserRole($adminRole);


        $manager->persist($simon);
        $manager->persist($john);
        $manager->persist($joachim);

        $manager->flush();
    }
}
