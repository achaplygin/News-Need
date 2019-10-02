<?php


namespace App\Service;


interface NewsServiceInterface
{
    public function receive();

    public function parse($data);
}
