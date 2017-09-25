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

    public function showDta($dtaI, $dtaF)
    {
        $m = new MongoClient();
        $collection = $m->selectDB('apifilmes')->selectCollection('filmes');

        $start = new MongoDate(strtotime($dtaI));
        $end = new MongoDate(strtotime($dtaF));
        
        $filmes = $collection->find(array('dta_estreia' => array('$gte' => $start, '$lte' => $end)));

        $filmeQuery = array();

        foreach ($filmes as $doc) {
            array_push($filmeQuery, $doc);
        }

        for($i=0;$i < count($filmeQuery); $i++) {
            $filmeQuery[$i]['dta_estreia'] = date('d-m-Y', $filmeQuery[$i]['dta_estreia']->sec);
        }

        $films = (object) $filmeQuery;

        return Rs::p(1,'Filmes no intervalo', $films);
    }

    public function add()
    {	
        $m = new MongoClient();
        $collection = $m->selectDB('apifilmes')->selectCollection('filmes');

    	$filme = $this->request->getPost();

        var_dump($filme);

        $d = new MongoDate(strtotime($filme['dta_estreia']));

        $filme['dta_estreia'] = $d;

        var_dump($filme['dta_estreia']);

        $collection->insert($filme);

        return Rs::p(1,'Filme adicionado',$filme);
    }

    public function update($film)
    {   
        $m = new MongoClient();
        $collection = $m->selectDB('apifilmes')->selectCollection('filmes');

        var_dump($film);

        $filme = $this->request->getPut();

        var_dump($filme);

        $collection->update(array('titulo'=>$film),$filme);

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