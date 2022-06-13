<?php

namespace App\Services\ArticlesUpdater\Facade;

use App\DTO\ArticleDTO;
use App\Models\Article;
use App\Services\ArticlesUpdater\DataParser\DataParserInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class LaravelBlogArticlesUpdater implements ArticlesUpdaterFacadeInterface
{
    public function __construct(private DataParserInterface $parser)
    {
    }

    /**
     *  Update articles data
     */
    public function update(): void
    {
        $articlesDTOs = $this->parser->parse();
        $this->saveArticles($articlesDTOs);
        $this->deleteOldArticles();
    }

    /**
     * Save parsed articles
     *
     * @param Collection $articlesDTOs
     */
    private function saveArticles(Collection $articlesDTOs): void
    {
        /** @var ArticleDTO $articlesDTO */
        foreach ($articlesDTOs as $articlesDTO) {
            $article = new Article();
            $article->text = $articlesDTO->getText();
            $article->header = $articlesDTO->getHeader();
            $article->link = $articlesDTO->getLink();
            $article->publication_date = $articlesDTO->getPublicationDate();
            $article->author_id = $articlesDTO->getAuthorId();
            $article->save();
            $article->tags()->attach($articlesDTO->getTagsIds());
        }
    }

    /**
     *  Delete articles less than config period
     */
    private function deleteOldArticles(): void
    {
        Article::where('publication_date', '<', (new Carbon())->subMonth(config('laravel_blog_parser.sub_month')))->delete();
    }
}
