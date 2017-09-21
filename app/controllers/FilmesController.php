<?php
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Collection;
use MongoDB\Driver\Manager;
use Phalcon\Mvc\Micro;

class FilmesController extends Controller
{
    public function index()
    {
        $filmes = Filmes::find();
        
        return Rs::p(1,'Todos os Filmes',$filmes);
    }

    public function show($film)
    {	
    	$filmeQuery = array(
            '$or' => array(
                array(
                    'titulo' => new MongoRegex("/$film/i"),
                    ),
                )
            );

    	$filme = Filmes::find(array($filmeQuery));
        return Rs::p(1,'Filme encontrado',$filme);
    }

    public function add()
    {	
        $m = new MongoClient();
        $collection = $m->selectDB('apifilmes')->selectCollection('filmes');

    	$filme = $this->request->getPost();

        var_dump($filme);

        //$collection->insert($filme);

        return Rs::p(1,'Filme adicionado',$filme);
    }

    public function update($film)
    {   
        $m = new MongoClient();
        $collection = $m->selectDB('apifilmes')->selectCollection('filmes');

        var_dump($film);

        $filme = $this->request->getPut();

        var_dump($filme);

        $collection->update(array('titulo'=>$film), array('$set'=>array($filme)));

        return Rs::p(1,'Filme atualizado',$filme);
    }

    public function delete($film)
    {   
        $m = new MongoClient();
        $collection = $m->selectDB('apifilmes')->selectCollection('filmes');

        var_dump($film);

        //var_dump($collection);

        $collection->remove(array('titulo'=>$film));

        return Rs::p(1,'Filme deletado',$film);
    }
}