<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityNotFoundException;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleController
 * @package App\Controller
 * @Route(name="article_controller_", path="/article/")
 */
class ArticleController extends AbstractController
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(name="index", path="", methods={"GET"})
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
     * @Route(name="show", path="{id}", methods={"GET"}, requirements={"id"="\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Article $article)
    {
        if (!$article) {
            throw $this->createNotFoundException('Article inconnu');
        }
        return $this->render(
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
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('article_controller_show', ['id' => $article->getId()]);
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
        if (!$article) {
            throw $this->createNotFoundException('Article inconnu');
        }
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('article_controller_show', ['id' => $article->getId()]);
        }
        return $this->render('article/update.html.twig', [
            'form' => $form->createView(),
            'article' => $article
        ]);
    }

    /**
     * @param Request $request
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route(name="delete", path="delete/{id}", methods={"GET", "POST"})
     */
    public function delete(Request $request, Article $article)
    {
        if (!$article) {
            throw $this->createNotFoundException('Article inconnu');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('article_controller_index');
    }
}
