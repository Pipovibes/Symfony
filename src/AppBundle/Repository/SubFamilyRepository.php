<?php

namespace AppBundle\Repository;

use AppBundle\Entity\SubFamily;
use Doctrine\ORM\EntityRepository;

class SubFamilyRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     * SELECT * FROM sub_family ORDER BY name ASC
     */
    public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('sub_family')
            ->orderBy('sub_family.name', 'ASC');
    }
}