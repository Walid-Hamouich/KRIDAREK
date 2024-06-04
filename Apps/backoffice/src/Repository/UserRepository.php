<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * 
     * @return User[]
     */
    public function findAllWithoutPassword(): array
    {
        return $this->createQueryBuilder('u')
            ->select('u.id, u.email, u.roles, u.lastName, u.firstName, u.phoneNum, u.blackListed')
            ->getQuery()
            ->getResult();
    }

    public function findAllButCurrentUserWithoutPassword($id): array
    {
        return $this->createQueryBuilder('u')
            ->select('u.id, u.email, u.roles, u.lastName, u.firstName, u.phoneNum, u.blackListed')
            ->where(['u.id != :id'])
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function findAllButCurrentUserWithoutPasswordWithRole(int $id, string $role)
    {
        return $this->createQueryBuilder('u')
            ->select('u.id, u.email, u.roles, u.lastName, u.firstName, u.phoneNum, u.blackListed')
            ->where(['u.id != :id', 'u.roles LIKE :role'])
            ->setParameter('id', $id)
            ->setParameter('role', "%$role%")
            ->getQuery()
            ->getResult();
    }


    public function countByRole(string $role): int
    {
        return $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->where('u.roles LIKE :role')
            ->setParameter('role', "%$role%")
            ->getQUery()
            ->getSingleScalarResult();
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
