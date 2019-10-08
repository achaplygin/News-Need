<?php

namespace App\Controller;

use App\Form\NewsForm;
use App\Form\NewsFormType;
use App\Service\NewsServiceFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SiteController
 * @package App\Controller
 */
class SiteController extends AbstractController
{
    /** @var NewsServiceFactory */
    private $newsServiceFactory;

    public function __construct(NewsServiceFactory $newsServiceFactory)
    {
        $this->newsServiceFactory = $newsServiceFactory;
    }

    /**
     * @Route("/", name="site")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): ?Response
    {
        $newsForm = new NewsForm();
        $form = $this->createForm(NewsFormType::class, $newsForm);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('news', [
                'source' => $newsForm->getSource(),
            ]);
        }

        return $this->render('site/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/news/{page<\d+>?1}", name="news")
     * @param Request $request
     * @param int $page
     * @return Response|null
     */
    public function news(Request $request, int $page = 1): ?Response
    {
        if (!$source = $request->query->get('source')) {
            return $this->redirectToRoute('site');
        }
        // prepare and load Form
        $newsForm = new NewsForm();
        $newsForm->setSource($source);
        $form = $this->createForm(NewsFormType::class, $newsForm);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('news', [
                'source' => $newsForm->getSource(),
            ]);
        }

        //Prepare NewsService
        $newsService = $this->newsServiceFactory->create($source);
        //Receive and parse news
        $allNews = $newsService->parse($newsService->receive());

        // pagination
        $news = [];
        $pageSize = 5;
        $page = ($page < count($allNews) / $pageSize) ? $page : 1;
        for ($i = ($page - 1) * $pageSize; ($i < $pageSize * $page) && ($i < count($allNews)); $i++) {
            $news[] = $allNews[$i];
        }

        return $this->render('site/news.html.twig', [
            'form' => $form->createView(),
            'news' => $news,
            'page' => $page,
            'maxPage' => count($allNews) / $pageSize,
        ]);
    }
}
