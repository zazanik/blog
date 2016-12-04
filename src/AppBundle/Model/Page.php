<?php

namespace AppBundle\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Model\Post;

/**
 * Class Page
 * @package AppBundle\Model
 */
class Page
{
    
    public function showAll()
    {
        
    }

    public function showById($id)
    {
        $file = file_get_contents('../src/AppBundle/Resources/file.json');
        $array = json_decode($file, true);
        $array = $array["{$id}"];
        $obj = new Post();
        $obj->setId($array["id"]);
        $obj->setThumb($array["thumb"]);
        $obj->setTitle($array["title"]);
        $obj->setContent($array["content"]);
        $obj->setAuthor($array["author"]);
        $obj->setDateCreated($array["date_created"]);
        $obj->setDateUpdate($array["date_update"]);
        return $obj;
    }
}