<?php

namespace App\DTO;

class LikeSongDto
{
    private bool $isLiked;

    /**
     * @return bool
     */
    public function isLiked(): bool
    {
        return $this->isLiked;
    }

    /**
     * @param bool $isLiked
     */
    public function setIsLiked(bool $isLiked): void
    {
        $this->isLiked = $isLiked;
    }
}