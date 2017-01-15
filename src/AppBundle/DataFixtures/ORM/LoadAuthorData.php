<?php
namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Author;

class LoadAuthorData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $author1 = new Author();
        $author1->setFirstName('Sasha');
        $author1->setLastName('Zaporozhets');
        $author1->setGender(1);
        $author1->setUser($this->getReference('admin'));

        $author2 = new Author();
        $author2->setFirstName('Alina');
        $author2->setLastName('Shvets');
        $author2->setGender(1);
        $author2->setUser($this->getReference('user'));

        $author3 = new Author();
        $author3->setFirstName('Vova');
        $author3->setLastName('Zakharchenko');
        $author3->setGender(1);
        $author3->setUser($this->getReference('test'));



        $manager->persist($author1);
        $manager->persist($author2);
        $manager->persist($author3);
        $manager->flush();

        $this->addReference('Sasha', $author1);

    }

    public function getOrder()
    {
        return 2;
    }
}