<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Archive;
use App\Entity\Filiere;
use App\Entity\Etudiant;
use App\Entity\Professeur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArchiveFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        $faker = Factory::create('fr_FR');

        $filieresliste = ['Mathematique','Physique','Informatique','Biologie','Geologie','Biologie/Geologie'];
        $typearchive = ['Mini Projet','Memoire','Rapport de stage','Projet Tutoriel'];
        //cree six filieres 
        
        for ($i=0; $i < 6; $i++) { 
            $filiere = new Filiere();
            $filiere->setName($filieresliste[$i]);
            $manager->persist($filiere);
            
            //Professeur
            $prof = new Professeur();
            $prof->addFiliere($filiere)
            ->setFirstname($faker->firstName())
            ->setLastname($faker->lastName())
            ->setIsVerified(true)
            ->setRoles(['ROLE_PROFESSEUR'])
            ->setEmail($faker->email())
            ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$OGRETFpqYUJEeGhyZTk4UA$iQECZNRncIqOW0F1i6y/xluCCSXniDymymhzN0CllDQ');
               
            $etudiant = new Etudiant();
            $etudiant->setNiveau(random_int(1,3))
            ->setFiliere($filiere)
            ->setFirstname($faker->firstName())
            ->setLastname($faker->lastName())
            ->setIsVerified(true)
            ->setRoles(['ROLE_USER'])
            ->setEmail($faker->email())
            ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$OGRETFpqYUJEeGhyZTk4UA$iQECZNRncIqOW0F1i6y/xluCCSXniDymymhzN0CllDQ');
           $manager->persist($prof);
           $manager->persist($etudiant);
            for ($j=0; $j < 25; $j++) { 
                $archive = new Archive();
                $archive->setTitle($faker->sentence())
                ->setUser($prof)
                ->setFiliere($filiere)
                ->setType($typearchive[random_int(0,1)])
                ->setRapportfilename(null)
                ->setImageFile(null)
                ->setEncadreur($faker->name())
                ->setDatepromotionOn($faker->dateTimeBetween('-6 years'))
                ->setDescription($faker->text());
                $manager->persist($archive);
            }
        }

        for ($i=0; $i <10 ; $i++) { 
            
        }
        $manager->flush();
    }
}
