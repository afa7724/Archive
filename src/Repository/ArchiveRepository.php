<?php

namespace App\Repository;

use App\Entity\Archive;
use Doctrine\ORM\Query;
use App\Data\SearchData;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PhpParser\Node\Expr\Isset_;

/**
 * @method Archive|null find($id, $lockMode = null, $lockVersion = null)
 * @method Archive|null findOneBy(array $criteria, array $orderBy = null)
 * @method Archive[]    findAll()
 * @method Archive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArchiveRepository extends ServiceEntityRepository
{
    private $paginator;
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Archive::class);
        $this->paginator = $paginator;
    }


    

    /*
    public function findOneBySomeField($value): ?Archive
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    private function getSearchQuery(SearchData $search,$user = null ,$filiere = null,$niveau = null): QueryBuilder
    {
        $query =  $this->createQueryBuilder('a')
                    
            ->orderBy('a.id', 'DESC');

        if (!is_null($user)) {
            $query = $query        
                    ->andWhere('a.user = :q')
                    ->setParameter('q',$user);
        }
        if (!is_null($filiere)) {
            $query = $query        
                    ->andWhere('a.filiere = :q')
                    ->setParameter('q',$filiere);
        }
        if (!is_null($niveau)) {
            $query = $query        
                    ->andWhere('a.Niveau = :q')
                    ->setParameter('q',$niveau);
        }
        if (!empty($search->q)) {
            $query = $query
                ->andWhere('a.title LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        


        if (!empty($search->filiere)) {
            $query = $query
                ->andWhere('a.filiere = :filiere')
                ->setParameter('filiere', $search->filiere->getid());
        }



        if ($search->typearchive >= 0 && !is_null($search->typearchive)) {
            $query = $query
                ->andWhere('a.type LIKE :typearchive')
                ->setParameter('typearchive', "%{$search->typearchive}%");
        }

        return $query;
    }
    public function findSearch(SearchData $search,$user,$filiere = null,$niveau = null): PaginationInterface
    {


        $query = $this->getSearchQuery($search,$user,$filiere)->getQuery();

        return $this->paginator->paginate(
            $query,
            $search->page,
            9
        );
    }
}
