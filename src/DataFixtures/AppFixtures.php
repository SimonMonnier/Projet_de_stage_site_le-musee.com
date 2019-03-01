<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
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

        
       $admin = new User();
       
       $hash = $this->encoder->encodePassword($admin, '44leMuseeAuto!');

       $admin->setFirstName("Magalie")
                ->setLastName("Simon")
                ->setHash($hash)
                ->setEmail("smagadom@yahoo.com")
                ->addUserRole($adminRole);

        $manager->persist($admin);

        $manager->flush();
    }
}
