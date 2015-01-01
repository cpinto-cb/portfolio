<?php
/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 12/26/14
 * Time: 2:09 PM
 */
require_once "bootstrap.php";
require_once "Model/Servers.php";

use Model\Servers;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

try {
    $page = getParam('page');
    $start = getParam('start');
    $limit = getParam('limit');
    $sort = getParam('sort');
    $dir = getParam('dir');
    $callback = getParam('callback');


    /** @var  Doctrine\ORM\QueryBuilder $qb */

    $orderBy = isset($dir) && isset($sort) ? "ORDER BY s.{$sort} {$dir} " : "";
    $qb = $entityManager->createQueryBuilder();
    $queryString = 'SELECT s.id, s.server_id, s.name, s.az, s.type, s.status, s.private_ip_address, s.public_ip_address FROM Model\Servers s '.$orderBy ;



//    $qb = $qb->select(array('status') )
//    ->from('Model\Servers','s');
//
//    if ( isset($sort) && isset($dir)){
//        $qb->addOrderBy($sort,$dir);
//    }
//    echo $qb->getDQL();
//
//    echo "\nthere";
//
//    var_dump($qb->getQuery()->getArrayResult());
//    echo "\nanywhere";

    /** @var Doctrine\ORM\Query $query */
    $query = $entityManager->createQuery($queryString);
    if ( strlen($start)>0 && strlen($limit)>0){
        $query->setMaxResults($limit);
        $query->setFirstResult($start);
//        $qb->setMaxResults($limit);
//        $qb->setFirstResult($start);
    }

    if ( isset($sort) ){

    }
    /** @var array $resultsArray */
    $resultsArray = $query->getResult();

    /** @var Doctrine\ORM\Query $countQuery */
    $countQuery = $entityManager->createQuery('SELECT count(s.id)  FROM Model\Servers s');
    $count = $countQuery->getScalarResult();
    $countResult = $count[0][1];

    header('Content-Type: application/json');
    echo jsonEncodeArray($resultsArray, $callback, $countResult);

} catch (Exception $e){
    echo "Exception" ;
    var_dump($e);
}

function jsonEncodeArray($results, $callback, $total=0){
    if ( sizeof($results) == 0){
        return "[]";
    }
    $temp = array();
    foreach($results as $object){
        $string = json_encode($object);
        if ( strlen($string) > 0){
            $temp[] =  json_encode($object,JSON_UNESCAPED_UNICODE);
        } else {
            error_log(var_export($object, true));
        }
    }
    $returnString = "{ 'totalCount':'{$total}', 'servers':[" . implode(",\n",$temp). "]}";
    if ( isset($callback)){
        $returnString =  "{$callback}({$returnString});";
    }

    return $returnString;

}

function getParam($name){

    return array_key_exists($name, $_REQUEST) ? $_REQUEST[$name] : null;

}
