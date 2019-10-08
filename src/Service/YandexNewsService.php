<?php

namespace App\Service;

use DateTime;

/**
 * Class YandexNewsService
 * @package App\Service
 */
class YandexNewsService extends NewsService
{
    /**
     * @param array $data
     * @return bool|DateTime|null
     */
    public function getDate(array $data)
    {
        return array_key_exists('pubDate', $data)
            ? DateTime::createFromFormat('d M Y H:i:s O', $data['pubDate'])
            : null;
    }

    /**
     * @param array $data
     * @return mixed|null
     */
    public function getText(array $data)
    {
        return $data['description'] ?? null;
    }

    /**
     * @param array $data
     * @return string|null
     */
    public function getTitle(array $data)
    {
        $ico = '<img src="https://www.google.com/s2/favicons?domain=news.yandex.ru">';
        return $ico . '&nbsp;' . $data['title'] ?? null;
    }

    public const LINKS = [
        'Авто' => 'https://news.yandex.ru/auto.rss',
        'Автоспорт' => 'https://news.yandex.ru/auto_racing.rss',
        'Армия и оружие' => 'https://news.yandex.ru/army.rss',
        'Баскетбол' => 'https://news.yandex.ru/basketball.rss',
        'В мире' => 'https://news.yandex.ru/world.rss',
        'Важное за сутки' => 'https://news.yandex.ru/daily.rss',
        'Волейбол' => 'https://news.yandex.ru/volleyball.rss',
        'Гаджеты' => 'https://news.yandex.ru/gadgets.rss',
        'Главное' => 'https://news.yandex.ru/index.rss',
        'Единоборства' => 'https://news.yandex.ru/martial_arts.rss',
        'ЖКХ' => 'https://news.yandex.ru/communal.rss',
        'Здоровье' => 'https://news.yandex.ru/health.rss',
        'Игры' => 'https://news.yandex.ru/games.rss',
        'Интернет' => 'https://news.yandex.ru/internet.rss',
        'Киберспорт' => 'https://news.yandex.ru/cyber_sport.rss',
        'Кино' => 'https://news.yandex.ru/movies.rss',
        'Космос' => 'https://news.yandex.ru/cosmos.rss',
        'Культура' => 'https://news.yandex.ru/culture.rss',
        'Лесные пожары' => 'https://news.yandex.ru/fire.rss',
        'Лига чемпионов' => 'https://news.yandex.ru/championsleague.rss',
        'Музыка' => 'https://news.yandex.ru/music.rss',
        'Наука' => 'https://news.yandex.ru/science.rss',
        'Недвижимость' => 'https://news.yandex.ru/realty.rss',
        'Общество' => 'https://news.yandex.ru/society.rss',
        'Политика' => 'https://news.yandex.ru/politics.rss',
        'Происшествия' => 'https://news.yandex.ru/incident.rss',
        'Путешествия' => 'https://news.yandex.ru/travels.rss',
        'Религия' => 'https://news.yandex.ru/religion.rss',
        'Спорт' => 'https://news.yandex.ru/sport.rss',
        'Театры' => 'https://news.yandex.ru/theaters.rss',
        'Теннис' => 'https://news.yandex.ru/tennis.rss',
        'Технологии' => 'https://news.yandex.ru/computers.rss',
        'Транспорт' => 'https://news.yandex.ru/vehicle.rss',
        'Фигурное катание' => 'https://news.yandex.ru/figure_skating.rss',
        'Финансы' => 'https://news.yandex.ru/finances.rss',
        'Футбол' => 'https://news.yandex.ru/football.rss',
        'Хоккей' => 'https://news.yandex.ru/hockey.rss',
        'Шоу-бизнес' => 'https://news.yandex.ru/showbusiness.rss',
        'Экология' => 'https://news.yandex.ru/ecology.rss',
        'Экономика' => 'https://news.yandex.ru/business.rss',
        'Энергетика' => 'https://news.yandex.ru/energy.rss',
    ];
}
