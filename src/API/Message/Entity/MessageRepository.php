<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 17/03/2016
 * Time: 03:40
 */

namespace API\Message\Entity;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class MessageRepository extends EntityRepository {

    public function countMessages()
    {
        $query = $this->createQueryBuilder("m")->getQuery()->getResult();

        return count($query);
    }

    public function getMessages($page = 0, $limit = 5)
    {
        $query =  $this->createQueryBuilder("m")
            ->orderBy('m.id', 'desc')
            ->getQuery()
            ->setFirstResult($page)
            ->setMaxResults($limit);

        $results = new Paginator($query);
        $totalResults = count($results);

        return [
            'totalResults' => $totalResults,
            'currentPage' => $page,
            'totalPages' => ceil($totalResults / $limit),
            'results' => $results
        ];
    }

    public function searchByWord($param, $page = 0, $limit = 5)
    {
        $dql = "SELECT m FROM API\Message\Entity\Message m WHERE m.message LIKE :param";
        $query =  $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter("param", "%{$param}%")
            ->setFirstResult($page)
            ->setMaxResults($limit);

        $results = new Paginator($query);
        $totalResults = count($results);

        return [
            'totalResults' => $totalResults,
            'currentPage' => $page,
            'totalPages' => ceil($totalResults / $limit),
            'results' => $results
        ];
    }

    public function searchByTag($param, $page = 0, $limit = 5){

        $query =  $this->createQueryBuilder("m")
            ->innerJoin("m.tags","mt")
            ->where("mt.id = $param")
            ->setFirstResult($page)
            ->setMaxResults($limit);


        $results = new Paginator($query);
        $totalResults = count($results);

        return [
            'totalResults' => $totalResults,
            'currentPage' => $page,
            'totalPages' => ceil($totalResults / $limit),
            'results' => $results
        ];
    }
}