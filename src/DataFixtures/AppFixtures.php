<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\User;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;
use Faker\Factory;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    
    private $faker;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadComments($manager);
        $this->loadBlogPosts($manager);
    }
    
    public function loadBlogPosts(ObjectManager $manager)
    {
        $user = $this->getReference('username1');
        
        for ($i = 0; $i < 100; $i++) {
            $blogPost = new BlogPost();
            $blogPost->setTitle($this->faker->realText(30));
            $blogPost->setPublished($this->faker->dateTime);
            $blogPost->setContent($this->faker->realText(10));
            $blogPost->setAuthor($user);
            $blogPost->setSlug($this->faker->slug);

            $this->setReference("blog_post$i", $blogPost);

            $manager->persist($blogPost);
        }


        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername("username1");
        $user->setName("name1");
        $user->setPassword($this->passwordEncoder->encodePassword($user, "psw1"));
        $user->setEmail("email1@gmail.com");
        $this->addReference('username1', $user);
        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setUsername("username2");
        $user->setName("name2");
        $user->setPassword($this->passwordEncoder->encodePassword($user, "psw2"));
        $user->setEmail("email2@gmail.com");
        $this->addReference('username2', $user);

        $manager->persist($user);
        $manager->flush();
    }

    public function loadComments(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            $comment = new Comment();
            $comment->setContent($this->faker->realText());
            $comment->setPublished($this->faker->dateTimeThisYear);
            $comment->setAuthor($this->getReference('username1'));
            
            $manager->persist($comment);
        }

        $manager->flush();

    }
}
