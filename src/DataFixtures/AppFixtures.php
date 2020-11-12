<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\User;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadComments($manager);
        $this->loadBlogPosts($manager);
    }

    public function loadBlogPosts(ObjectManager $manager)
    {
        $user = $this->getReference('username1');
        $blogPost = new BlogPost();
        $blogPost->setTitle("A first post!");
        $blogPost->setPublished(new \DateTime('2020-11-09 14:34:00'));
        $blogPost->setContent('Post text');
        $blogPost->setAuthor($user);
        $blogPost->setSlug('a-first-blog');

        $manager->persist($blogPost);

        $user = $this->getReference('username2');
        $blogPost = new BlogPost();
        $blogPost->setTitle("A second post!");
        $blogPost->setPublished(new \DateTime('2020-11-09 14:35:00'));
        $blogPost->setContent('Post text');
        $blogPost->setAuthor($user);
        $blogPost->setSlug('a-second-blog');

        $manager->persist($blogPost);

        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername("username1");
        $user->setName("name1");
        $user->setPassword("psw1");
        $user->setEmail("email1@gmail.com");
        $this->addReference('username1', $user);
        $manager->persist($user);
        $manager->flush();
        
        $user = new User();
        $user->setUsername("username2");
        $user->setName("name2");
        $user->setPassword("psw2");
        $user->setEmail("email2@gmail.com");
        $this->addReference('username2', $user);

        $manager->persist($user);
        $manager->flush();
    }

    public function loadComments(ObjectManager $manager)
    {
        
    }

}
