<?php
namespace App\Controller;

use App\Entity\Article;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogControler extends AbstractController
{
    /**
     *
     * @Route("/{page}",name="index",defaults={"page": 1})
     *
     */
    public function list($page)
    {

        $article = new Article($this->getData());
        $articles = $article->getArticles("Hry | PC", $page , 9);

        return $this->render(
            'blog/list.html.twig' , array("articles" => $articles["data"], "pages" => round($articles["pages"]))
        );
    }

    /**
     * @Route("/detail/{slug}", name="articleShow")
     */
    public function detail($slug)
    {
        $article = new Article($this->getData());
        $articleDetail = $article->getArticle($slug);

        return $this->render(
            'blog/detail.html.twig', array("article" => $articleDetail)
        );
    }

    public function getData() {
        $xml = simplexml_load_string(file_get_contents ( dirname(__FILE__)."/../../public/shop.xml"), null
            , LIBXML_NOCDATA);
        $json = json_encode($xml);
        return json_decode($json,TRUE);
    }

}