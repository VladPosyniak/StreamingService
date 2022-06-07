<?php

namespace App\Model;

class ArtistsPageModel
{
    public const DEFAULT_LIMIT = 20;

    private int $limit = self::DEFAULT_LIMIT;
    private ?int $genre = null;
    private ?string $searchWord = null;

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