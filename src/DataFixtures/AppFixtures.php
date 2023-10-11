<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\DataFixtures\Provider\AppProvider;
use App\Entity\Category;
use App\Entity\Century;
use App\Entity\Picture;
use App\Entity\Place;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        // TODO : créer 20 lieux historiques (voir sources), 18 catégories (voirs sources), 5 tags, 30 siècles

        $faker = Factory::create("fr_FR");
        // a custom faker provider, for our specific datas
        $faker->addProvider(new AppProvider());

        // before create places, must create categories, tags, periods and users
        
        // ! USER
        $userList = [];
        for ($i = 0; $i < 3; $i++) {
            $dataUser = $faker->unique()->user();
            $user = new User();
            $user->setEmail($dataUser['email']);
            $user->setRoles($dataUser['roles']);
            $user->setPassword($this->passwordHasher->hashPassword($user, $dataUser['password']));
            $user->setLastname($dataUser['lastname']);
            $user->setFirstname($dataUser['firstname']);
            $user->setPseudonym($dataUser['pseudonym']);
            $user->setIsActive($dataUser['isActive']);
            $user->setCreatedAt(new \DateTimeImmutable($faker->date()));
            $userList[] = $user;
            $manager->persist($user);
        }

        // ! CATEGORY
        $categoryList = [];
        foreach ($faker->getCategories() as $dataCategory) {
            $category = new Category();
            $category->setName($dataCategory[0]);
            $category->setIcon($dataCategory[1]);
            $category->setCreatedAt(new \DateTimeImmutable($faker->date()));
            $categoryList[] = $category;
            $manager->persist($category);
        }

        // ! CENTURY

        $centuryList= [];
        foreach ($faker->getCenturies() as $dataCentury) {
            $century = new Century();
            $century->setCentury($dataCentury['century']);
            $century->setPeriod($dataCentury['period']);
            $century->setCreatedAt(new \DateTimeImmutable($faker->date()));
            $centuryList[] = $century;
            $manager->persist($century);
        }

        // ! TAGS
        $tagList = [];
        for ($i=0; $i < 10; $i++) { 
            $tag = new Tag();
            $tagName = $faker->sentence(4);
            $tag->setName($tagName);
            $tag->setCreatedAt(new \DateTimeImmutable($faker->date()));
            $tagList[] = $tag;
            $manager->persist($tag);
        }

        // ! PLACE

        foreach ($faker->getPlaces() as $dataPlace) {
            $place = new Place();
            $place->setName($dataPlace['name']);
            $place->setCoordinate($dataPlace['coordinate']);
            $place->setAdress($dataPlace['adress']);
            $place->setPostcode($dataPlace['postcode']);
            $place->setCity($dataPlace['city']);
            $place->setCountry($dataPlace['country']);
            $place->setWebsite($dataPlace['website']);
            $place->setPhone($dataPlace['phone']);
            $place->setDescription($faker->paragraph(8));
            $place->setPrice($dataPlace['price']);
            $place->setOpeningHours($dataPlace['opening_hours']);
            $place->setRating($faker->randomFloat(1, 1, 5));
            $place->setAccessibility($dataPlace['accessibility']);
            $place->setGuidedTour($dataPlace['guided_tour']);
            $place->setIsValid($dataPlace['isValid']);
            $place->setSlug($dataPlace['slug']);
            $place->setCreatedAt(new \DateTimeImmutable($faker->date()));

            $place->setUsers($userList[array_rand($userList)]);
            $place->addCategory($categoryList[array_rand($categoryList)]);
            $place->addCentury($centuryList[array_rand($centuryList)]);
            $place->addTag($tagList[array_rand($tagList)]);

            // ! PICTURE
            $picture = new Picture();
            $picture->setName($place->getName());
            $picture->setPictureLegend($dataPlace['picture']['picture_legend']);
            $picture->setUrl($dataPlace['picture']['url']);
            $picture->setCreatedAt(new \DateTimeImmutable($faker->date()));
            $manager->persist($picture);

            $place->addPicture($picture);

            $manager->persist($place);
        }

        $manager->flush();
    }
}
