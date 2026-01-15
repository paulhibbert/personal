<?php

namespace App\Models;

use Sushi\Sushi;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Topic extends Model
{
    use Sushi;

    protected $rows = [
        ['id' => 0, 'href' => 'places', 'name' => 'Places Visited'],
        ['id' => 1, 'href' => 'genealogy', 'name' => 'Family History'],
        ['id' => 2, 'href' => 'code', 'name' => 'Programming'],
        ['id' => 3, 'href' => 'learning', 'name' => 'Learning'],
    ];

    public static function getArticlesForTopic(string $topicHref): array
    {
        $articles = [];
        $files = Storage::disk('docs')->files($topicHref);
        foreach ($files as $file) {
            $articles[] = Str::of($file)->between('/', '.')->ucfirst()->toString();
        }

        return $articles;
    }
}
