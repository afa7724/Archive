<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('filiere', [$this, 'formatFiliere']),
        ];
    }

    public function formatFiliere($filiere)
    {
        

        return '';
    }
}