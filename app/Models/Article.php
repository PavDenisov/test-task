<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class Article extends Model
{
    protected $guarded = [];

    protected $casts = [
        'publication_date' => 'date:d.m.Y',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Get Articles ordered by user request
     *
     * @param Request $request
     * @return Builder
     */
    public static function tableFilter(Request $request): Builder
    {
        $accessor = ($request->get('accessor')) ?? 'authors.name';
        $order = ($request->get('order')) ?? 'asc';

        return self::select(['articles.*', 'authors.name as author_name', DB::raw('GROUP_CONCAT(tags.name SEPARATOR \', \') as tags')])
            ->join('article_tag', 'article_tag.article_id', '=', 'articles.id')
            ->join('tags', 'tags.id', '=', 'article_tag.tag_id')
            ->join('authors', 'articles.author_id', '=', 'authors.id')
            ->orderBy($accessor, $order)
            ->groupBy('articles.id');
    }
}
