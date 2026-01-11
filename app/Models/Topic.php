<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class Topic extends Model
{
    use Sushi;

    protected $rows = [
        ['id' => 0, 'href' => 'places', 'name' => 'Places Visited'],
        ['id' => 1, 'href' => 'genealogy', 'name' => 'Family History'],
        ['id' => 2, 'href' => 'code', 'name' => 'Programming'],
        ['id' => 3, 'href' => 'music', 'name' => 'Music'],
        ['id' => 4, 'href' => 'books', 'name' => 'Notable Books'],
        ['id' => 5, 'href' => 'art', 'name' => 'Notable Artworks'],
    ];
}
