<?php

namespace App\Service;

use DateTime;

/**
 * Class YandexNewsService
 * @package App\Service
 */
class YandexNewsService extends NewsService
{
    public function __construct($source)
    {
        parent::__construct($source);
    }

    public function getDate(array $data)
    {
        return array_key_exists('pubDate', $data)
            ? DateTime::createFromFormat('d M Y H:i:s O', $data['pubDate'])
            : null;
    }

    public function getText(array $data)
    {
        return $data['description'] ?? null;
    }

    public function getTitle(array $data)
    {
        $ico = '<img src="https://www.google.com/s2/favicons?domain=news.yandex.ru">';
        return $ico . '&nbsp;' . $data['title'] ?? null;
    }
}
