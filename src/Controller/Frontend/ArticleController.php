<?php

namespace App\Controller\Frontend;

use App\Entity\Article;
use App\Search\SearchArticle;
use App\Form\SearchArticleType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/article', name: "app.article")]
class ArticleController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepository $repo
    ) {
    }

    #[Route('/liste', name: '.index', methods: ['GET'])]
    public function index( Request $request): Response|JsonResponse

    {


        $searchArticle = new SearchArticle();

        $searchArticle->setPage($request->query->get('page',1));

        $form = $this->createForm(SearchArticleType::class,$searchArticle);
        $form->handleRequest($request);

        $articles = $this->repo->findSearchArticle($searchArticle);

        if($request->query->get('ajax')) {
            return new JsonResponse([
                'content' => $this->renderView('Components/_articleList.html.twig',[
                    'articles' => $articles,
                ]),
                'sortable' => $this->renderView('Components/_sortable.html.twig',[
                    'articles' => $articles,
                ]),
                'pagination' => $this->renderView('Components/_pagination.html.twig',[
                    'articles' => $articles,
                ]),
                'count' => $this->renderView('Components/_count.html.twig',[
                    'articles' => $articles,
                ]),
                'totalPage' => ceil($articles->getTotalItemCount() / $articles->getItemNumberPerPage())
            ]);

        }

        return $this->render('Frontend/Article/index.html.twig', [
            'articles' => $articles,
            'form' => $form,
            'totalPage' => ceil($articles->getTotalItemCount() / $articles->getItemNumberPerPage()),
            
        ]);
    }

    #[Route('/{slug}', name: '.show', methods: ['GET'])]
    public function showArticle(?Article $article): Response|RedirectResponse
    {
        if (!$article instanceof Article || !$article->isActif()) {
            $this->addFlash('error', 'Article not found');

            return $this->redirectToRoute('app.article.index');
        }

        return $this->render('Frontend/Article/show.html.twig', [
            'article' => $article,
        ]);
    }
}
