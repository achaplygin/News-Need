<?php

namespace App\Service;

/**
 * Interface NewsServiceInterface
 * @package App\Service
 */
interface NewsServiceInterface
{
    /**
     * @return string|null
     */
    public function receive(): ?string;

    /**
     * @param $data
     * @return array
     */
    public function parse($data): array;
}
