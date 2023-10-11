<?php

namespace App\Repository;

use App\Entity\Place;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Place>
 *
 * @method Place|null find($id, $lockMode = null, $lockVersion = null)
 * @method Place|null findOneBy(array $criteria, array $orderBy = null)
 * @method Place[]    findAll()
 * @method Place[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Place::class);
    }

    public function add(Place $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Place $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllByTitleSearch(?string $search = null ): ?array
    {
        return $this->createQueryBuilder('p')
        ->orderBy("p.name")
        ->Where ("p.name LIKE :search")
        ->setParameter("search", "%".$search."%")
        ->getQuery()
        ->getResult()
        ;
    }

    public function findByCategory($category): array
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->innerJoin('p.categories', 'c')
            ->innerJoin('p.pictures', 'i')
            ->addSelect('c')
            ->addSelect('i')
            ->where('c.id = :category_id')
            ->setParameter('category_id', $category->getId())
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByCentury($century): array
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->innerJoin('p.centuries', 'c')
            ->innerJoin('p.pictures', 'i')
            ->addSelect('c')
            ->addSelect('i')
            ->where('c.id = :century_id')
            ->setParameter('century_id', $century->getId())
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByTag($tag): array
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->innerJoin('p.tags', 't')
            ->innerJoin('p.pictures', 'i')
            ->addSelect('t')
            ->addSelect('i')
            ->where('t.id = :tag_id')
            ->setParameter('tag_id', $tag->getId())
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByPeriod($century): array
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->innerJoin('p.centuries', 'c')
            ->innerJoin('p.pictures', 'i')
            ->addSelect('c')
            ->addSelect('i')
            ->where('c.period = :century_period')
            ->setParameter('century_period', $century->getPeriod())
            ->getQuery()
            ->getResult()
        ;
    }


    public function findByFilter($datas)
    {
        // integrating the query builder in a variable
        $qb = $this->createQueryBuilder('p');
        // select the 'place' table by aliasing it
        $qb->select('p');

        /* Example of a manual query for categuory's table

        $qb->innerJoin('p.categories', 'ca');
        $qb->addSelect('ca');
        $qb->andwhere('ca.id = :ca_id0 OR ca.id = :ca_id1');
        $qb->setParameter('ca_id0', $datas['categories'][0]);
        $qb->setParameter('ca_id1', $datas['categories'][1]);
        
        $qb->innerJoin('p.centuries', 'ce');
        $qb->addSelect('ce');
        $qb->andwhere('ce.id = :ce_id0');
        $qb->setParameter('ce_id0', $datas['centuries'][0]);

        3 requests of this type are needed to perform the custom query
        and each query must have a dynamic variable for indentification
        */
        
        // fully dynamic request
        // we loop over $datas, we retrieve the key and the values that will be useful
        foreach ($datas as $entity => $data) {
            // if the occurrence is not null or empty, we start building the query
            if ($data) {
                // retrieve the first 2 letters of the key to boost aliases
                $entityAlias = substr($entity, 0, 2);
                // join the table concerned and assign it a dynamic alias
                $qb->innerJoin('p.'.$entity, $entityAlias);
                // select the entity
                $qb->addSelect($entityAlias);
                // initialise the 1st occurrence in the "where" variable
                $where = $entityAlias.'.id = :'.$entityAlias.'_id0';
                // initialise the 1st occurrence in the $parameters variable
                $parameters[$entityAlias.'_id0'] = $data[0];
                // if $data contains more than one value, we loop from the 2nd occurrence
                // to concatenate the rest of the request in the $where variable  
                // and add the corresponding parameter to the $parameters array
                if (count($data) > 1) {
                    for ($i = 1; $i < count($data); $i++) {
                        $where = $where . ' OR '. $entityAlias.'.id = :'.$entityAlias.'_id'.$i;
                        $parameters[$entityAlias.'_id'.$i] = $data[$i];
                    }
                }
                // add the query to the query builder
                $qb->andWhere($where);
            }
        }
        // loop over the parameters to bind them (prevent sql injection)
        foreach ($parameters as $index => $parameter) {
            $qb->setParameter($index, $parameter);
        }

        // return the result as an array
        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Place[] Returns an array of Place objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Place
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
