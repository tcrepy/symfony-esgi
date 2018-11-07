<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 0; $i < 20; $i++) {
            $article = new Article();
            $article->setContent($faker->text);
            $article->setName($faker->name);
            $manager->persist($article);
        }
        $manager->flush();
    }
}
