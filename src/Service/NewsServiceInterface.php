<?php


namespace App\Service;


interface NewsServiceInterface
{
    public function receive(): ?string;

    public function parse($data): array;
}
