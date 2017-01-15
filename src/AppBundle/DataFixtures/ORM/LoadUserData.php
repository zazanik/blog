<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;


class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setLogin('admin');
        $user1->setPassword('12345678');
        $user1->setEmail('somemail@gmail.com');
        $user1->setCreatedAt(date_create());

        $user2 = new User();
        $user2->setLogin('Alinka22');
        $user2->setPassword('12345678');
        $user2->setEmail('somemail2@gmail.com');
        $user2->setCreatedAt(date_create());

        $user3 = new User();
        $user3->setLogin('test');
        $user3->setPassword('87654321');
        $user3->setEmail('somemail3@gmail.com');
        $user3->setCreatedAt(date_create());


        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->flush();


        $this->addReference('admin', $user1);
        $this->addReference('user', $user2);
        $this->addReference('test', $user3);
    }

    public function getOrder()
    {
        return 1;
    }
}