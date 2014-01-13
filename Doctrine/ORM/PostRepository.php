<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\Doctrine\ORM;

use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use SymEdit\Bundle\BlogBundle\Model\CategoryInterface;
use SymEdit\Bundle\BlogBundle\Model\Post;

class PostRepository extends EntityRepository
{
    public function findAllOrdered()
    {
        return $this->getRecentQuery()->getResult();
    }
    
    public function findPublished()
    {
        return $this
            ->getQueryBuilder()
            ->andWhere('o.status = :status')
            ->setParameter('status', Post::PUBLISHED)
            ->getQuery()
            ->getResult();
    }

    public function findPopular($max = null)
    {
        $qb = $this->getPopularQueryBuilder();

        if ($max !== null) {
            $qb->setMaxResults($max);
        }

        return $qb->getQuery()->getResult();
    }

    public function findByCategoryQueryBuilder(CategoryInterface $category)
    {
        return $this->getQueryBuilder()
                  ->where(':category MEMBER OF o.categories')
                  ->setParameter('category', $category);
    }

    public function findByCategory(CategoryInterface $category)
    {
        return $this->findByCategoryQueryBuilder($category)->getQuery()->getResult();
    }

    public function getPopularQueryBuilder()
    {
        return $this->createQueryBuilder('p')
                    ->orderBy('p.views', 'desc');
    }

    public function getRecentQuery()
    {
        return $this->getQueryBuilder()->getQuery();
    }

    public function getRecent($max=3)
    {
        return $this->getRecentQuery()
                ->setMaxResults($max)
                ->getResult();
    }

    /**
     * Get just the most recent post
     */
    public function getRecentPost()
    {
        return $this->getRecentQuery()
                ->setMaxResults(1)
                ->getSingleResult();
    }

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        return parent::getQueryBuilder()
                   ->orderBy(sprintf('%s.createdAt', $this->getAlias()), 'DESC');
    }
}