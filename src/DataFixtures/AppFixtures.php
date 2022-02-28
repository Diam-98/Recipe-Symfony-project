<?php

namespace App\DataFixtures;

use App\Entity\Ingrediant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(){
        $this->faker = Factory::create("fr-FR");
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);


        for ($i=1; $i<=50; $i++){
            $ingrediant = new Ingrediant();
            $ingrediant->setName($this->faker->word());
            $ingrediant->setPrice(mt_rand(0, 100));
            $manager->persist($ingrediant);
        }


        $manager->flush();
    }
}
