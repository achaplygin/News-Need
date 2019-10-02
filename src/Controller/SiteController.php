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
        $newsService = new NewsService('lenta', 'Мир');
        $result = $newsService->parse($newsService->receive());
        $news = $result['channel']['item'];

        return $this->render('site/news.html.twig', [
            'controller_name' => 'SiteController',
            'news' => $news,
        ]);
    }
}
