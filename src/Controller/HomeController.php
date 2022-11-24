<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function search(ArticleRepository $articleRepository, Request $request): Response
    {

        $search = $request->query->get('q');
        if ($search) {
            $article = $articleRepository->search($search);
        } else {
            $article = $articleRepository->findAll();
        }

        return $this->render('home/index.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Article $article)
    {

        $xmlPath = $article->getFile();
        $xmlLast = substr($xmlPath, -3);
        if ($xmlLast == 'xml') {


            $xmlStr = file_get_contents($this->getParameter('file_folder') . DIRECTORY_SEPARATOR . $xmlPath);
            $xml = simplexml_load_string($xmlStr);

            $json = json_encode($xml);
            $array = json_decode($json, TRUE);
            array_walk_recursive($array, function ($item, $key) use (&$results) {
                $results[$key] = $item;
            });
        } else {
            $results = '';

        }


        return $this->render('home/show.html.twig', [
            'article' => $article,
            'results' => $results
        ]);
    }


}
