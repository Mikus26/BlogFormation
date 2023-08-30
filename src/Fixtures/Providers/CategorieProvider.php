<?php

namespace App\Fixtures\Providers;

class CategorieProvider
{
    public function randomTag(): string
    {
        $tags = [
            'PHP',
            'SYMFONY',
            'REACT',
            'VueJS',
            'ANGULAR',
            'FRAMEWORK',
            'BACKEND',
            'FRONTEND',
            'FULLSTACK',
            'API',
            'REST',
            'GRAPHQL',
            'SQL',
            'MYSQL'

        ];



        return $tags[array_rand($tags)];
    }
}