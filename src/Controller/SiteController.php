<?php

namespace App\Controller;

use App\Service\NewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
        $source = 'https://lenta.ru/';
        $category = 'Топ 7';

        $newsService = new NewsService($source, $category);
        $news = $newsService->parse($newsService->receive());

        return $this->render('site/news.html.twig', [
            'controller_name' => 'SiteController',
            'news' => $news,
        ]);
    }
}
