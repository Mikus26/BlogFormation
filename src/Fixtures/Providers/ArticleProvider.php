<?php

namespace App\Fixtures\Providers;

use Faker\Factory;
use Faker\Generator;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ArticleProvider
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function generateLoremContent(): string
   {
    return file_get_contents('https://loripsum.net/api/10/long/headers/link/ul/dl');
   } 

   public function generateDateTimeImmutable(): \DateTimeImmutable
   {
    return \DateTimeImmutable::createFromMutable($this->faker->dateTimeThisYear()) ;
   }

   public function uploadImageArticle(): UploadedFile
   {
        $files = glob(realpath(__DIR__ . '/Images/Articles/') . '/*.*') ;

        $file = $files[array_rand($files)];

        $imageFile = new File($file);

        return new UploadedFile($imageFile, $imageFile->getFilename());



   }
}