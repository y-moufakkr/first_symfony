<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;
   
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder=$encoder;
        
    }
    public function load(ObjectManager $manager)
    {
        
        $user1=new User();
       
        $user1->setUsername("super_admin")
                ->setEmail("super.admin@gmail.com")
                ->setPassword("superadmin")
                ->setRoles(['ROLE_ADMIN','ROLE_USER','ROLE_SUPER_ADMIN']);
         $hash1=$this->encoder->encodePassword($user1,$user1->getPassword());
            $user1->setPassword($hash1);
        $user2=new User();
        $user2->setUsername("admin_admin")
                ->setEmail("admin.admin@gmail.com")
                ->setPassword("adminadmin")
                ->setRoles(['ROLE_ADMIN','ROLE_USER']);
        $hash2=$this->encoder->encodePassword($user2,$user2->getPassword());
            $user2->setPassword($hash2);
         $user3=new User();
        $user3->setUsername("user_user")
                ->setEmail("user.user@gmail.com")
                ->setPassword("useruser")
                ->setRoles(['ROLE_USER']);
        $hash3=$this->encoder->encodePassword($user3,$user3->getPassword());
            $user3->setPassword($hash3);
        // $product = new Product();
         $manager->persist($user1);
         $manager->persist($user2);
        $manager->persist($user3);

        $manager->flush();
    }
}
