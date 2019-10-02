<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class NewsService
{
    private $source;
    private $category;
    private $client;
    private $encoder;

    public function __construct($source, $category)
    {
        $this->source = $source;
        $this->category = $category;
        $this->client = HttpClient::create();
        $this->encoder = new XmlEncoder();
    }

    public function receive()
    {
        return $this->client->request('GET', $this->links[$this->source][$this->category])->getContent();
    }

    public function parse($data)
    {
        return $this->encoder->decode($data, '');
    }

    private $links = [
        /** https://yandex.ru/news/export */
        'yandex' => [
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
        ],
        /** https://lenta.ru/info/posts/export/ */
        'lenta' => [
            'Новости' => 'https://lenta.ru/rss/news',
            'Топ 7' => 'https://lenta.ru/rss/top7',
            'За сутки' => 'https://lenta.ru/rss/last24',
            'Россия' => 'https://lenta.ru/rss/news/russia',
        ],
        /** https://www.vedomosti.ru/info/rss */
        'vedomosti' => [
            'Все материалы' => 'https://www.vedomosti.ru/rss/articles',
            'Последний номер газеты' => 'https://www.vedomosti.ru/rss/issue',
            'Действующие лица' => 'https://www.vedomosti.ru/rss/library/characters',
            'Расследования' => 'https://www.vedomosti.ru/rss/library/investigations',
            'Бизнес' => [
                'Бизнес' => 'https://www.vedomosti.ru/rss/rubric/business',
                'ТЭК' => 'https://www.vedomosti.ru/rss/rubric/business/energy',
                'Промышленность' => 'https://www.vedomosti.ru/rss/rubric/business/industry',
                'Транспорт' => 'https://www.vedomosti.ru/rss/rubric/business/transport',
                'Агропром' => 'https://www.vedomosti.ru/rss/rubric/business/agriculture',
                'Торговля и услуги' => 'https://www.vedomosti.ru/rss/rubric/business/retail',
                'Спортивный бизнес' => 'https://www.vedomosti.ru/rss/rubric/business/sport',
            ],
            'Экономика' => [
                'Экономика' => 'https://www.vedomosti.ru/rss/rubric/economics',
                'Макроэкономика и бюджет' => 'https://www.vedomosti.ru/rss/rubric/economics/macro',
                'Госинвестиции и проекты' => 'https://www.vedomosti.ru/rss/rubric/economics/state_investments',
                'Мировая экономика' => 'https://www.vedomosti.ru/rss/rubric/economics/global',
                'Налоги и сборы' => 'https://www.vedomosti.ru/rss/rubric/economics/taxes',
                'Правила' => 'https://www.vedomosti.ru/rss/rubric/economics/regulations',
            ],
            'Финансы' => [
                'Финансы' => 'https://www.vedomosti.ru/rss/rubric/finance',
                'Банки' => 'https://www.vedomosti.ru/rss/rubric/finance/banks',
                'Рынки' => 'https://www.vedomosti.ru/rss/rubric/finance/markets',
                'Профучастники' => 'https://www.vedomosti.ru/rss/rubric/finance/players',
                'Страхование' => 'https://www.vedomosti.ru/rss/rubric/finance/insurance',
                'Персональные финансы' => 'https://www.vedomosti.ru/rss/rubric/finance/personal_finance',
            ],
            'Мнения' => [
                'Мнения' => 'https://www.vedomosti.ru/rss/rubric/opinion',
                'Детали' => 'https://www.vedomosti.ru/rss/rubric/opinion/details',
                'Аналитика' => 'https://www.vedomosti.ru/rss/rubric/opinion/analytics',
                'От редакции' => 'https://www.vedomosti.ru/rss/rubric/opinion/editorial',
            ],
            'Политика' => [
                'Политика' => 'https://www.vedomosti.ru/rss/rubric/politics',
                'Власть' => 'https://www.vedomosti.ru/rss/rubric/politics/official',
                'Демократия' => 'https://www.vedomosti.ru/rss/rubric/politics/democracy',
                'Международные отношения' => 'https://www.vedomosti.ru/rss/rubric/politics/international',
                'Безопасность и право' => 'https://www.vedomosti.ru/rss/rubric/politics/security_law',
                'Социальная политика' => 'https://www.vedomosti.ru/rss/rubric/politics/social',
                'Международная жизнь' => 'https://www.vedomosti.ru/rss/rubric/politics/foreign',
            ],
            'Технологии' => [
                'Технологии' => 'https://www.vedomosti.ru/rss/rubric/technology',
                'Телекоммуникации' => 'https://www.vedomosti.ru/rss/rubric/technology/telecom',
                'Интернет и digital' => 'https://www.vedomosti.ru/rss/rubric/technology/internet',
                'Медиа' => 'https://www.vedomosti.ru/rss/rubric/technology/media',
                'ИТ-бизнес' => 'https://www.vedomosti.ru/rss/rubric/technology/it_business',
                'Персональные технологии' => 'https://www.vedomosti.ru/rss/rubric/technology/personal_technologies',
                'Наукоемкие технологии' => 'https://www.vedomosti.ru/rss/rubric/technology/hi_tech',
                'Недвижимость' => [
                    'Недвижимость' => 'https://www.vedomosti.ru/rss/rubric/realty',
                    'Жилая недвижимость' => 'https://www.vedomosti.ru/rss/rubric/realty/housing',
                    'Коммерческая недвижимость' => 'https://www.vedomosti.ru/rss/rubric/realty/commercial_property',
                    'Стройки и инфраструктура' => 'https://www.vedomosti.ru/rss/rubric/realty/infrastructure',
                    'Архитектура и дизайн' => 'https://www.vedomosti.ru/rss/rubric/realty/architecture',
                    'Место для жизни' => 'https://www.vedomosti.ru/rss/rubric/realty/districts',
                ],
                'Авто' => [
                    'Авто' => 'https://www.vedomosti.ru/rss/rubric/auto',
                    'Автомобильная промышленность' => 'https://www.vedomosti.ru/rss/rubric/auto/auto_industry',
                    'Легковые автомобили' => 'https://www.vedomosti.ru/rss/rubric/auto/cars',
                    'Коммерческие автомобили' => 'https://www.vedomosti.ru/rss/rubric/auto/commercial_vehicles',
                    'Дизайн и технологии' => 'https://www.vedomosti.ru/rss/rubric/auto/car_design',
                    'Тест-драйвы' => 'https://www.vedomosti.ru/rss/rubric/auto/test_drive',
                ],
                'Менеджмент' => [
                    'Менеджмент' => 'https://www.vedomosti.ru/rss/rubric/management',
                    'Карьера' => 'https://www.vedomosti.ru/rss/rubric/management/career',
                    'Управление' => 'https://www.vedomosti.ru/rss/rubric/management/management',
                    'Зарплаты и занятость' => 'https://www.vedomosti.ru/rss/rubric/management/compensation',
                    'Предпринимательство' => 'https://www.vedomosti.ru/rss/rubric/management/entrepreneurship',
                    'Бизнес-образование' => 'https://www.vedomosti.ru/rss/rubric/management/education',
                ],
                'Стиль жизни' => [
                    'Стиль жизни' => 'https://www.vedomosti.ru/rss/rubric/lifestyle',
                    'Досуг' => 'https://www.vedomosti.ru/rss/rubric/lifestyle/leisure',
                    'Культура' => 'https://www.vedomosti.ru/rss/rubric/lifestyle/culture',
                    'Люкс' => 'https://www.vedomosti.ru/rss/rubric/lifestyle/luxury',
                    'Интервью' => 'https://www.vedomosti.ru/rss/rubric/lifestyle/interview',
                    'Линии жизни' => 'https://www.vedomosti.ru/rss/rubric/lifestyle/lifeline',
                ],
            ]
        ],
    ];
}
