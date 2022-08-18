<?php

namespace App\DataFixtures;

use DateTimeImmutable;
use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $categoryNames = ["Voyages","Famille","Hobbies"];
        // $categories = []; //Tableau vide
        // foreach($categoryNames as $categoryName){
        //     //parcours notre tableau de Category, et pour chaque élément initialise une Category et la ranger dans le tableau $categories
        //     $category = new Category;
        //     $category->setName($categoryName);
        //     array_push($categories, $category);
        //     $manager->persist($category);
        // }

        for($i=1; $i <= 50; $i++){
            $article = new Article();
            $article->setTitle("Titre n°$i")
                    ->setContent("Contenu de l'article n°$i")
                    ->setImage("https://via.placeholder.com/600x150")
                    ->setCreatedAt(new DateTimeImmutable('now'));
                    // ->setCategory($categories[rand(0, 2)]);

            $manager->persist($article);
        }
        $manager->flush();
    }
}
