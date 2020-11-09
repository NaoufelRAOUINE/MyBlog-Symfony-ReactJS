<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $blogPost = new BlogPost();
        $blogPost->setTitle("A first post!");
        $blogPost->setPublished(new \DateTime('2020-11-09 14:34:00'));
        $blogPost->setContent('Post text');
        $blogPost->setAuthor('Naoufel1434');
        $blogPost->setSlug('a-first-blog');

        $manager->persist($blogPost);

        $blogPost = new BlogPost();
        $blogPost->setTitle("A second post!");
        $blogPost->setPublished(new \DateTime('2020-11-09 14:35:00'));
        $blogPost->setContent('Post text');
        $blogPost->setAuthor('Naoufel1434');
        $blogPost->setSlug('a-second-blog');

        $manager->persist($blogPost);

        $manager->flush();
    }
}
