<?php
namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Post;


class LoadPostData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        //Create your Faker generator
        $faker = \Faker\Factory::create();

        for ($i=0; $i < 10; $i++) {

            $post[$i] = new Post();
            $post[$i]->setTitle($faker->text(100));
            $post[$i]->setDescription($faker->text);
            $post[$i]->setContent($faker->text(2000));
            $post[$i]->setImage($faker->imageUrl(640, 480, null, false));
            $post[$i]->setCreatedAt($faker->dateTime);
            $post[$i]->setAuthor($this->getReference('Sasha'));

            $manager->persist($post[$i]);
            $manager->flush();

        }



    }

    public function getOrder()
    {
        return 3;
    }
}