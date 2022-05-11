<?php
namespace App\Data;

use App\Entity\Category;

class SearchData
{

    /**
     * @var string
     */
    public string $q = '';

    /**
     * @var Category[]
     */
    public array $categories = [];

}