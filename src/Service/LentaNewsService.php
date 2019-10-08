<?php

namespace App\Service;

use App\Entity\NewsPost;
use DateTime;

/**
 * Class LentaNewsService
 * @package App\Service
 */
class LentaNewsService extends NewsService
{
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
        $ico = '<img src="https://www.google.com/s2/favicons?domain=lenta.ru">';
        return $ico . '&nbsp;' . $data['title'] ?? null;
    }

    public const LINKS  = [
        'Новости' => 'https://lenta.ru/rss/news',
        'Топ 7' => 'https://lenta.ru/rss/top7',
        'За сутки' => 'https://lenta.ru/rss/last24',
        'Россия' => 'https://lenta.ru/rss/news/russia',
        'Мир' => 'https://lenta.ru/rss/news/world',
    ];
}
