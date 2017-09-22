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

        var_dump($start);

        var_dump($end);

        $rangeQuery = array(
            'dta_estreia' => array(
                array(
                    '$gt' => $start
                ),
                array(
                    '$lt' => $end
                ),              
            )
        );

        var_dump($rangeQuery);

        $filmes = Filmes::find($rangeQuery);
        
        //$filmes = $collection->find(array("dta_estreia" => array('$gt' => $start, '$lte' => $end)));
        //$filmes = Filmes::find(array('dta_estreia' => array('$eq' => array('$gte' => $start, '$lte' => $end))));

        $newdate = date('d-m-Y', $d->sec);
        
        return Rs::p(1,'Filmes no intervalo',$filmes);
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