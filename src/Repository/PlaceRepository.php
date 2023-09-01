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
        // on créer le query builder dans une variable
        $qb = $this->createQueryBuilder('p');
        // on sélectione la table 'place' avec son alias
        $qb->select('p');

        /* Exemple de requète manuel
        $qb->innerJoin('p.categories', 'ca');
        $qb->addSelect('ca');
        $qb->andwhere('ca.id = :ca_id0 OR ca.id = :ca_id1');
        $qb->setParameter('ca_id0', $datas['categories'][0]);
        $qb->setParameter('ca_id1', $datas['categories'][1]);
        
        $qb->innerJoin('p.centuries', 'ce');
        $qb->addSelect('ce');
        $qb->andwhere('ce.id = :ce_id0');
        $qb->setParameter('ce_id0', $datas['centuries'][0]);
        */
        
        // requète complètement dynamique
        // on boucle sur les datas, $entity permet de dynamiser la requète et ne faire qu'une seule boucle
        foreach ($datas as $entity => $data) {
            // si l'occurence n'est pas null ou vide on commence à contruire la requète
            if ($data) {
                // récupération des 2 premières lettre de la clé pour dynamiser les alias
                $entityAlias = substr($entity, 0, 2);
                // on joint la table concernée et on lui affecte l'alias
                $qb->innerJoin('p.'.$entity, $entityAlias);
                // on sélectionne l'entité
                $qb->addSelect($entityAlias);
                // on initialise la variable "where" avec une 1ere occurence
                $where = $entityAlias.'.id = :'.$entityAlias.'_id0';
                // on initialise la variable $parameters avec une 1ere occurence
                $parameters[$entityAlias.'_id0'] = $data[0];
                // si $data contient plus d'une valeur on boucle à partir de la 2ème occurence
                // pour concaténer le reste de la requète dans la variable $where et on ajoute 
                // le paramètre correspondant au tableau $parameters
                if (count($data) > 1) {
                    for ($i = 1; $i < count($data); $i++) {
                        $where = $where . ' OR '. $entityAlias.'.id = :'.$entityAlias.'_id'.$i;
                        $parameters[$entityAlias.'_id'.$i] = $data[$i];
                    }
                }
                // on ajoute la requète au query builder
                $qb->andWhere($where);
            }
        }
        // on boucle sur les paramètres pour les binder
        foreach ($parameters as $index => $parameter) {
            $qb->setParameter($index, $parameter);
        }

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
