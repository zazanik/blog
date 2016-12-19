<?php

namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setNickname('zazanik');
        $user1->setFirstName('Sasha');
        $user1->setPassword('12345678');

        $user2 = new User();
        $user2->setNickname('zazik');
        $user2->setFirstName('Sasha');
        $user2->setPassword('87654321');

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->flush();

        $this->addReference('zazanik', $user1);
        $this->addReference('zazik', $user2);
    }

    public function getOrder()
    {
        return 2;
    }
}
