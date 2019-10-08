<?php

namespace App\Service;

use DateTime;

/**
 * Class VedomostiNewsService
 * @package App\Service
 */
class VedomostiNewsService extends NewsService
{
    /**
     * @param array $data
     * @return bool|DateTime|null
     */
    public function getDate(array $data)
    {
        return array_key_exists('pubDate', $data)
            ? DateTime::createFromFormat(DateTime::RFC2822, $data['pubDate'])
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
        $ico = '<img src="https://www.google.com/s2/favicons?domain=www.vedomosti.ru">';
        return $ico . '&nbsp;' . $data['title'] ?? null;
    }

    public const LINKS = [
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
    ];
}
