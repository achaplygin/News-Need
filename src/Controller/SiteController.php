<?php

namespace App\Controller;

use App\Form\NewsForm;
use App\Form\NewsFormType;
use App\Service\NewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
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
            $newsForm = $form->getData();
            return $this->redirectToRoute('news', [
                'source' => $newsForm->getSource(),
            ]);
        }

        return $this->render('site/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/news", name="news")
     * @param Request $request
     * @return Response|null
     */
    public function news(Request $request): ?Response
    {
        $source = $request->query->get('source');

        $newsForm = new NewsForm();
        $newsForm->setSource($source);
        $form = $this->createForm(NewsFormType::class, $newsForm);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newsForm = $form->getData();
            return $this->redirectToRoute('news', [
                'source' => $newsForm->getSource(),
            ]);
        }

        $newsService = NewsService::createService($source);
        $news = $newsService->parse($newsService->receive());

        return $this->render('site/news.html.twig', [
            'form' => $form->createView(),
            'news' => $news,
        ]);
    }
}
