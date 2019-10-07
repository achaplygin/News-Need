<?php

namespace App\Service;

use App\Entity\NewsPost;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

abstract class NewsService implements NewsServiceInterface
{
    /** @var \Symfony\Contracts\HttpClient\string */
    protected $source;
    /** @var HttpClient */
    protected $client;
    /** @var XmlEncoder */
    protected $encoder;

    /**
     * @param $link
     * @return NewsService
     */
    public static function createService($link): NewsService
    {
        if (in_array($link, self::$links['Lenta.ru'], true)) {
            return new LentaNewsService($link);
        }
        if (in_array($link, self::$links['Yandex News'], true)) {
            return new YandexNewsService($link);
        }
        if (in_array($link, self::$links['Vedomosti'], true)) {
            return new VedomostiNewsService($link);
        }

        throw new NotFoundHttpException();
    }

    protected function __construct($source)
    {
        $this->source = $source;
        $this->client = HttpClient::create();
        $this->encoder = new XmlEncoder();
    }

    public function receive(): ?string
    {
        return $this->client->request('GET', $this->source)->getContent();
    }

    public function parse($data): array
    {
        $items = $this->encoder->decode($data, '');
        $news = [];
        foreach ($items['channel']['item'] as $item) {
            $news[] = new NewsPost([
                'title' => $this->getTitle($item),
                'date' => $this->getDate($item),
                'text' => $this->getText($item),
                'link' => array_key_exists('link', $item) ? $item['link'] : '',
                'image' => array_key_exists('enclosure', $item) ? $item['enclosure']['@url'] : '',
                'source' => $this->source,
            ]);
        }

        return $news;
    }

    private static $links = [
        /* https://lenta.ru/info/posts/export/ */
        'Lenta.ru' => [
            'Новости' => 'https://lenta.ru/rss/news',
            'Топ 7' => 'https://lenta.ru/rss/top7',
            'За сутки' => 'https://lenta.ru/rss/last24',
            'Россия' => 'https://lenta.ru/rss/news/russia',
            'Мир' => 'https://lenta.ru/rss/news/world',
        ],
        /* https://yandex.ru/news/export */
        'Yandex News' => [
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
        /* https://www.vedomosti.ru/info/rss */
        'Vedomosti' => [
            'Все материалы' => 'https://www.vedomosti.ru/rss/articles',
            'Последний номер газеты' => 'https://www.vedomosti.ru/rss/issue',
            'Действующие лица' => 'https://www.vedomosti.ru/rss/library/characters',
            'Расследования' => 'https://www.vedomosti.ru/rss/library/investigations',
            'Бизнес' => 'https://www.vedomosti.ru/rss/rubric/business',
            'Бизнес-ТЭК' => 'https://www.vedomosti.ru/rss/rubric/business/energy',
            'Бизнес-Промышленность' => 'https://www.vedomosti.ru/rss/rubric/business/industry',
            'Бизнес-Транспорт' => 'https://www.vedomosti.ru/rss/rubric/business/transport',
            'Бизнес-Агропром' => 'https://www.vedomosti.ru/rss/rubric/business/agriculture',
            'Бизнес-Торговля и услуги' => 'https://www.vedomosti.ru/rss/rubric/business/retail',
            'Бизнес-Спортивный бизнес' => 'https://www.vedomosti.ru/rss/rubric/business/sport',
            'Экономика' => 'https://www.vedomosti.ru/rss/rubric/economics',
            'Экономика-Макроэкономика и бюджет' => 'https://www.vedomosti.ru/rss/rubric/economics/macro',
            'Экономика-Госинвестиции и проекты' => 'https://www.vedomosti.ru/rss/rubric/economics/state_investments',
            'Экономика-Мировая экономика' => 'https://www.vedomosti.ru/rss/rubric/economics/global',
            'Экономика-Налоги и сборы' => 'https://www.vedomosti.ru/rss/rubric/economics/taxes',
            'Экономика-Правила' => 'https://www.vedomosti.ru/rss/rubric/economics/regulations',
            'Финансы' => 'https://www.vedomosti.ru/rss/rubric/finance',
            'Финансы-Банки' => 'https://www.vedomosti.ru/rss/rubric/finance/banks',
            'Финансы-Рынки' => 'https://www.vedomosti.ru/rss/rubric/finance/markets',
            'Финансы-Профучастники' => 'https://www.vedomosti.ru/rss/rubric/finance/players',
            'Финансы-Страхование' => 'https://www.vedomosti.ru/rss/rubric/finance/insurance',
            'Финансы-Персональные финансы' => 'https://www.vedomosti.ru/rss/rubric/finance/personal_finance',
            'Мнения' => 'https://www.vedomosti.ru/rss/rubric/opinion',
            'Мнения-Детали' => 'https://www.vedomosti.ru/rss/rubric/opinion/details',
            'Мнения-Аналитика' => 'https://www.vedomosti.ru/rss/rubric/opinion/analytics',
            'Мнения-От редакции' => 'https://www.vedomosti.ru/rss/rubric/opinion/editorial',
            'Политика' => 'https://www.vedomosti.ru/rss/rubric/politics',
            'Политика-Власть' => 'https://www.vedomosti.ru/rss/rubric/politics/official',
            'Политика-Демократия' => 'https://www.vedomosti.ru/rss/rubric/politics/democracy',
            'Политика-Международные отношения' => 'https://www.vedomosti.ru/rss/rubric/politics/international',
            'Политика-Безопасность и право' => 'https://www.vedomosti.ru/rss/rubric/politics/security_law',
            'Политика-Социальная политика' => 'https://www.vedomosti.ru/rss/rubric/politics/social',
            'Политика-Международная жизнь' => 'https://www.vedomosti.ru/rss/rubric/politics/foreign',
            'Технологии' => 'https://www.vedomosti.ru/rss/rubric/technology',
            'Технологии-Телекоммуникации' => 'https://www.vedomosti.ru/rss/rubric/technology/telecom',
            'Технологии-Интернет и digital' => 'https://www.vedomosti.ru/rss/rubric/technology/internet',
            'Технологии-Медиа' => 'https://www.vedomosti.ru/rss/rubric/technology/media',
            'Технологии-ИТ-бизнес' => 'https://www.vedomosti.ru/rss/rubric/technology/it_business',
            'Технологии-Персональные технологии' => 'https://www.vedomosti.ru/rss/rubric/technology/personal_technologies',
            'Технологии-Наукоемкие технологии' => 'https://www.vedomosti.ru/rss/rubric/technology/hi_tech',
            'Недвижимость' => 'https://www.vedomosti.ru/rss/rubric/realty',
            'Недвижимость-Жилая недвижимость' => 'https://www.vedomosti.ru/rss/rubric/realty/housing',
            'Недвижимость-Коммерческая недвижимость' => 'https://www.vedomosti.ru/rss/rubric/realty/commercial_property',
            'Недвижимость-Стройки и инфраструктура' => 'https://www.vedomosti.ru/rss/rubric/realty/infrastructure',
            'Недвижимость-Архитектура и дизайн' => 'https://www.vedomosti.ru/rss/rubric/realty/architecture',
            'Недвижимость-Место для жизни' => 'https://www.vedomosti.ru/rss/rubric/realty/districts',
            'Авто' => 'https://www.vedomosti.ru/rss/rubric/auto',
            'Авто-Автомобильная промышленность' => 'https://www.vedomosti.ru/rss/rubric/auto/auto_industry',
            'Авто-Легковые автомобили' => 'https://www.vedomosti.ru/rss/rubric/auto/cars',
            'Авто-Коммерческие автомобили' => 'https://www.vedomosti.ru/rss/rubric/auto/commercial_vehicles',
            'Авто-Дизайн и технологии' => 'https://www.vedomosti.ru/rss/rubric/auto/car_design',
            'Авто-Тест-драйвы' => 'https://www.vedomosti.ru/rss/rubric/auto/test_drive',
            'Менеджмент' => 'https://www.vedomosti.ru/rss/rubric/management',
            'Менеджмент-Карьера' => 'https://www.vedomosti.ru/rss/rubric/management/career',
            'Менеджмент-Управление' => 'https://www.vedomosti.ru/rss/rubric/management/management',
            'Менеджмент-Зарплаты и занятость' => 'https://www.vedomosti.ru/rss/rubric/management/compensation',
            'Менеджмент-Предпринимательство' => 'https://www.vedomosti.ru/rss/rubric/management/entrepreneurship',
            'Менеджмент-Бизнес-образование' => 'https://www.vedomosti.ru/rss/rubric/management/education',
            'Стиль жизни' => 'https://www.vedomosti.ru/rss/rubric/lifestyle',
            'Стиль жизни-Досуг' => 'https://www.vedomosti.ru/rss/rubric/lifestyle/leisure',
            'Стиль жизни-Культура' => 'https://www.vedomosti.ru/rss/rubric/lifestyle/culture',
            'Стиль жизни-Люкс' => 'https://www.vedomosti.ru/rss/rubric/lifestyle/luxury',
            'Стиль жизни-Интервью' => 'https://www.vedomosti.ru/rss/rubric/lifestyle/interview',
            'Стиль жизни-Линии жизни' => 'https://www.vedomosti.ru/rss/rubric/lifestyle/lifeline',
        ],
    ];

    public function getLinks()
    {
        return self::$links;
    }
}
