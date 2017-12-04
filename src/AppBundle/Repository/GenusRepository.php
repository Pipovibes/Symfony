<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Genus;
use Doctrine\ORM\EntityRepository;

class GenusRepository extends EntityRepository
{
    /**
     * @return Genus[]
     * SELECT * FROM genus WHERE is_published = true ORDER BY species_count DESC
     */
    public function findAllPublishedOrderedBySize()
    {
        return $this->createQueryBuilder('genus')
            ->andWhere('genus.isPublished = :isPublished')
            ->setParameter('isPublished', true)
            ->orderBy('genus.speciesCount', 'DESC')
            ->getQuery()
            ->execute();
    }

    /**
     * @return Genus[]
     * Return active genus ordered by the most recent note
     * SELECT genus.* FROM genus LEFT JOIN genus_note ON genus.id = genus_note.genus_id WHERE genus.is_published = true ORDER BY genus_note.created_at DESC
     */
    public function findAllPublishedOrderedByRecentlyActive()
    {
        return $this->createQueryBuilder('genus')
            ->andWhere('genus.isPublished = :isPublished')
            ->setParameter('isPublished', true)
            ->leftJoin('genus.notes', 'genus_note')
            ->orderBy('genus_note.createdAt', 'DESC')
            ->getQuery()
            ->execute();
    }
}