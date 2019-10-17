<?php

namespace App\Controller;

use App\Form\NewsForm;
use App\Form\NewsFormType;
use App\Service\NewsServiceFactory;
use Knp\Component\Pager\PaginatorInterface;
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

    /** @var PaginatorInterface */
    private $paginator;

    /**
     * SiteController constructor.
     * @param NewsServiceFactory $newsServiceFactory
     * @param PaginatorInterface $paginator
     */
    public function __construct(NewsServiceFactory $newsServiceFactory, PaginatorInterface $paginator)
    {
        $this->newsServiceFactory = $newsServiceFactory;
        $this->paginator = $paginator;
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
        $newsForm = new NewsForm();
        $newsForm->setSource($source);
        $form = $this->createForm(NewsFormType::class, $newsForm);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('news', [
                'source' => $newsForm->getSource(),
            ]);
        }

        $newsService = $this->newsServiceFactory->create($source);
        $allNews = $newsService->parse($newsService->receive());

        $pagination = $this->paginator->paginate($allNews, $page, 5);

        return $this->render('site/news.html.twig', [
            'form' => $form->createView(),
            'page' => $page,
            'pagination' => $pagination,
        ]);
    }
}
