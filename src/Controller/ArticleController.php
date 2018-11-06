<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleController
 * @package App\Controller
 * @Route(name="article_controller_", path="/article")
 */
class ArticleController extends AbstractController
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(name="index", path="/", methods={"GET"})
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository(Article::class)->findAll();
        return $this->render(
            'article/index.html.twig',
            ['articles' => $articles]
        );
    }

    /**
     * @param Article $article
     * @Route(name="show", path="/{id}", methods={"GET"})
     */
    public function show(Article $article)
    {
        $this->render(
            'article/show.html.twig',
            ['article' => $article]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route(name="create", path="new", methods={"GET", "POST"})
     */
    public function new(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('article_controller_show');
        }
        return $this->render('article/create.html.twig', [
            'form' => $form->createView(),
            'article' => $article
        ]);

    }

    /**
     * @param Request $request
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route(name="update", path="update/{id}", methods={"GET", "POST"})
     */
    public function update(Request $request, Article $article)
    {
        $form = $this->createForm(ArticleType::class, $article);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('article_controller_show');
        }
        return $this->render('article/update.html.twig', [
            'form' => $form->createView(),
            'article' => $article
        ]);

    }
}
