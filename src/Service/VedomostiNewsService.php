<?php

namespace App\Service;

use App\Entity\NewsPost;
use DateTime;

/**
 * Class VedomostiNewsService
 * @package App\Service
 */
class VedomostiNewsService extends NewsService
{
    public function __construct($source)
    {
        parent::__construct($source);
    }

    public function getDate(array $data)
    {
        return array_key_exists('pubDate', $data)
            ? DateTime::createFromFormat(DateTime::RFC2822, $data['pubDate'])
            : null;
    }

    public function getText(array $data)
    {
        return $data['description'] ?? null;
    }

    public function getTitle(array $data)
    {
        $ico = '<img src="https://www.google.com/s2/favicons?domain=www.vedomosti.ru">';
        return $ico . '&nbsp;' . $data['title'] ?? null;
    }
}
