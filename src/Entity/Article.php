<?php

namespace App\Entity;

class Article {

    private $dataArray;

    public function __construct($dataArray)
    {
        $this->dataArray = $dataArray;
    }

    public function getArticles($categoryName = "",$page = 0, $limit = 6) {

        $articles = array();
        $articlesSort = array();
        foreach($this->dataArray["SHOPITEM"] as $item) {

            if($item["CATEGORYTEXT"] == $categoryName) {
                $articles[$item["ITEM_ID"]] = $item;
                $articlesSort[$item["ITEM_ID"]] = $item["PRODUCT"];
            }
        }

        $result = array();

        asort($articlesSort);
        $i = 0;
        foreach($articlesSort as $articleId => $articleValue) {
            if($i >= $page * $limit AND $i < $page * $limit + $limit) {
                $result[$articleId] = $articles[$articleId] ;
            }

            $i++;
        }

        return array(
            "data" => $result,
            "pages" => count($articles) / $limit
        );

    }

    public function getArticle($id) {
        foreach($this->dataArray["SHOPITEM"] as $item) {

            if($item["ITEM_ID"] == $id) {
                return $item;
            }
        }

        return null;
    }


}

?>