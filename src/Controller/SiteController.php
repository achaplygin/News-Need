<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Util\XmlUtils;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class SiteController extends AbstractController
{
    /**
     * @Route("/", name="site")
     */
    public function index()
    {
        return $this->render('site/index.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }

    /**
     * @Route("/news", name="news")
     */
    public function news()
    {
        ///////// тестовый БЛОК /////////
        $client = HttpClient::create();
        $encoder = new XmlEncoder();
        $response = $client->request('GET', 'https://news.yandex.ru/index.rss');
        $result = $encoder->decode($response->getContent(), '');
        $news = $result['channel']['item'];
        /////////////////////////////////

        return $this->render('site/news.html.twig', [
            'controller_name' => 'SiteController',
            'news' => $news,
        ]);
    }
}
