<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ReleasePageModel
{
    public const TYPE_FEATURED = 'featured';
    public const TYPE_POPULAR = 'popular';
    public const TYPE_NEWEST = 'newest';

    public const DEFAULT_LIMIT = 20;

    private int $limit = self::DEFAULT_LIMIT;
    private ?int $genre = null;
    private ?string $searchWord = null;
    private ?string $type = null;

    public function getLimit(): string
    {
        return $this->limit;
    }

    public function setLimit(string $limit): void
    {
        $this->limit = $limit;
    }


    /**
     * @return string|null
     */
    public function getSearchWord(): ?string
    {
        return $this->searchWord;
    }

    /**
     * @param string|null $searchWord
     */
    public function setSearchWord(?string $searchWord): void
    {
        $this->searchWord = $searchWord;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return int|null
     */
    public function getGenre(): ?int
    {
        return $this->genre;
    }

    /**
     * @param int|null $genre
     */
    public function setGenre(?int $genre): void
    {
        $this->genre = $genre;
    }
}