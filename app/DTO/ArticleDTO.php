<?php

namespace App\DTO;

use Carbon\Carbon;

class ArticleDTO
{
    /**
     * @var string
     */
    private string $text;

    /**
     * @var string
     */
    private string $header;

    /**
     * @var string
     */
    private string $link;

    /**
     * @var Carbon
     */
    private Carbon $publicationDate;

    /**
     * @var int
     */
    private int $authorId;

    /**
     * @var array
     */
    private array $tagsIds;

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * @param string $header
     */
    public function setHeader(string $header): void
    {
        $this->header = $header;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return Carbon
     */
    public function getPublicationDate(): Carbon
    {
        return $this->publicationDate;
    }

    /**
     * @param Carbon $publicationDate
     */
    public function setPublicationDate(Carbon $publicationDate): void
    {
        $this->publicationDate = $publicationDate;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @param int $authorId
     */
    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }

    /**
     * @return array
     */
    public function getTagsIds(): array
    {
        return $this->tagsIds;
    }

    /**
     * @param array $tagsIds
     */
    public function setTagsIds(array $tagsIds): void
    {
        $this->tagsIds = $tagsIds;
    }
}
