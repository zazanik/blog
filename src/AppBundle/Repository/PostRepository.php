<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Category;
use Doctrine\ORM\Tools\Pagination\Paginator;
/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
    public function sortByDate()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select("p")->from("AppBundle:Post", "p")->orderBy('p.createdAt', 'DESC');

        return $query->getQuery()->getResult();
    }


    /**
     * @param int $currentPage
     * @return mixed
     */
    public function getAllPosts($currentPage = 1)
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->getQuery();
        $paginator = $this->paginate($query, $currentPage);
        return $paginator;
    }

//    public function getPostsByCategoryID($id)
//    {
//        $qb = $this->getEntityManager()->createQueryBuilder();
//
//        $query = $qb->select('c')
//            ->from('AppBundle:Category', 'c')
//            ->where('c.id ='.$id)
//            ->getQuery();
//
//        return $query->getResult();
//    }

    public function paginate($dql, $page = 1, $limit = 7)
    {
        if ($page === null) {
            $page = 1;
        }
        $paginator = new Paginator($dql, $fetchJoinCollection = true);
        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);
        return $paginator;
    }
}
