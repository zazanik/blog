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
        $post1 = new Post();
        $post1->setTitle('Починаю з простого');
        $post1->setContent('Cras consequat iaculis lorem, id vehicula erat mattis quis. Vivamus laoreet 
         velit justo, in ven e natis purus pretium sit amet. Praesent lectus tortor, tincidu nt in consectetur 
         vestibulum, ultrices nec neque. Praesent nec sagittis mauris. Fusce convallis nunc neque. Integer 
         egestas aliquam interdum. Nulla ante diam, interdum nec tempus eu, feugiat vel erat. Integer aliquam 
         mi quis accum san porta.Quisque nec turpis nisi. Proin lobortis nisl ut orci euismod, et lobortis est 
         scelerisque. Sed eget volutpat ipsum. Integer fring illa leo porttitor, ultrices quam non, lobortis 
         ligula. Aliquam vel consequat arcu. On the other hand, we denounce with righteous indignation and 
         dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded 
         by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame 
         belongs to those who fail in their duty through weakness of will, which is the same as saying through 
         shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. The other hand,
          we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the 
          charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble 
          that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of 
          will, which is the same as saying through shrinking from toil and pain. These cases are perfectly 
          simple and easy to distinguish');
        $post1->setAuthor($this->getReference('zazanik'));
        $post1->setImage('/img/img.jpg');

        $post2 = new Post();
        $post2->setTitle('Простого не буває');
        $post2->setContent('Cras consequat iaculis lorem, id vehicula erat mattis quis. Vivamus laoreet 
         velit justo, in ven e natis purus pretium sit amet. Praesent lectus tortor, tincidu nt in consectetur 
         vestibulum, ultrices nec neque. Praesent nec sagittis mauris. Fusce convallis nunc neque. Integer 
         egestas aliquam interdum. Nulla ante diam, interdum nec tempus eu, feugiat vel erat. Integer aliquam 
         mi quis accum san porta.Quisque nec turpis nisi. Proin lobortis nisl ut orci euismod, et lobortis est 
         scelerisque. Sed eget volutpat ipsum. Integer fring illa leo porttitor, ultrices quam non, lobortis 
         ligula. Aliquam vel consequat arcu. On the other hand, we denounce with righteous indignation and 
         dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded 
         by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame 
         belongs to those who fail in their duty through weakness of will, which is the same as saying through 
         shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. The other hand,
          we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the 
          charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble 
          that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of 
          will, which is the same as saying through shrinking from toil and pain. These cases are perfectly 
          simple and easy to distinguish');
        $post2->setAuthor($this->getReference('zazik'));
        $post2->setImage('/img/img.jpg');

        $manager->persist($post1);
        $manager->persist($post2);
        $manager->flush();

        $this->addReference('post1', $post1);
        $this->addReference('post2', $post2);
    }

    public function getOrder()
    {
        return 6;
    }
}
