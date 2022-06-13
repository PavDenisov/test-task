<?php

namespace App\Services\ArticlesUpdater\DataParser;

use App\DTO\ArticleDTO;
use App\Models\Article;
use App\Models\Author;
use App\Models\Tag;
use App\Services\ArticlesUpdater\HttpClient\HttpClientInterface;
use App\Traits\HasAttemptsTrait;
use Exception;
use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;
use Carbon\Carbon;

class LaravelBlogParser implements DataParserInterface
{
    use HasAttemptsTrait;

    public function __construct(private HttpClientInterface $httpClient)
    {
    }

    /**
     * Parse data
     *
     * @return Collection
     * @throws Exception
     */
    public function parse(): Collection
    {
        $articlesDTOs = $this->getArticlesLinks();

        return $this->parseArticles($articlesDTOs);
    }

    /**
     * Get articles links needed to parse
     *
     * @return Collection
     * @throws Exception
     */
    private function getArticlesLinks(): Collection
    {
        /** date check sub mouth may be change in config */
        $dateCheck = (new Carbon())->subMonth(config('laravel_blog_parser.sub_month'));
        /** page counter to parse */
        $page = 1;
        $data = new Collection();
        /** parse while date check or run out of attempts */
        while ($page && $this->attemptsCheck()) {
            $uri = '/blog?page='.$page;
            $request = $this->httpClient->get($uri);
            if ($request->getStatusCode() === 200) {
                $response = $request->getBody()->getContents();
                $crawler = new Crawler($response);
                foreach ($crawler->filter('li.card a') as $node) {
                    $node = new Crawler($node);
                    $articleDTO = new ArticleDTO();
                    $tag = $node->filter('div span')->text();
                    $articleDTO->setPublicationDate(new Carbon($node->filter('div p')->text()));
                    $articleDTO->setHeader($node->filter('div .text-black span')->text());
                    $articleDTO->setLink($node->attr('href'));
                    /** if the tag is not among those set in the settings or the article is already in the database, skip  */
                    if (!in_array($tag, config('laravel_blog_parser.tags')) || Article::where('link', '=', $articleDTO->getLink())->exists()) {
                        continue;
                    }
                    /** if the parser has reached the articles more than the date specified in the settings, finish  */
                    if ($dateCheck > $articleDTO->getPublicationDate()) {
                        break 2;
                    }
                    $data->push($articleDTO);
                }
                $page++;
            } else {
                /** if something went wrong, try again after the interval specified in the settings  */
                $this->setAttempts($this->getAttempts() + 1);
                sleep(config('attempts.laravel_blog_delay'));
            }
        }

        return $data;
    }

    /**
     * Parse articles
     *
     * @param Collection $articlesDTOs
     * @return Collection
     * @throws Exception
     */
    private function parseArticles(Collection $articlesDTOs): Collection
    {
        /** @var ArticleDTO $articlesDTO */
        foreach ($articlesDTOs as $articlesDTO) {
            /** parse while run out of attempts */
            do {
                $request = $this->httpClient->get($articlesDTO->getLink());
                if ($request->getStatusCode() === 200) {
                    $response = $request->getBody()->getContents();
                    $crawler = new Crawler($response);
                    $articlesDTO->setText($crawler->filter('article div.prose-sm')->html());
                    $tagsIds = [];
                    $crawler->filter('article div.flex a span')->each(function (Crawler $crawler) use (&$tagsIds) {
                        $tagId = Tag::firstOrCreate(['name' => $crawler->text()]);
                        $tagsIds[] = $tagId->id;
                    });
                    $articlesDTO->setTagsIds($tagsIds);
                    $articlesDTO->setAuthorId(Author::firstOrCreate(['name' => $crawler->filter('article div.flex p.text-black a')->text()])->id);
                } else {
                    /** if something went wrong, try again after the interval specified in the settings  */
                    $this->setAttempts($this->getAttempts() + 1);
                    sleep(config('attempts.laravel_blog_delay'));
                }
            } while ($this->attemptsCheck() && $this->getAttempts());
        }

        return $articlesDTOs;
    }
}
