<?php

declare(strict_types=1);

namespace BplUser\Mapper;

use CirclicalUser\Provider\GroupPermissionInterface;
use CirclicalUser\Mapper\GroupPermissionMapper as CirGroupPermissionMapper;

//This to solve the bug in getPermissions() method
class GroupPermissionMapper extends CirGroupPermissionMapper {

    /**
     * @return GroupPermissionInterface[]
     */
    public function getPermissions(string $string): array {
        $query = $this->getRepository()->createQueryBuilder('r')
                ->select('r')
                ->where('r.resource_class = :resourceClass AND r.resource_id=:resourceId')
                ->setParameter('resourceClass', $string)
                ->setParameter('resourceId', $string)
                ->getQuery();

        return $query->getResult();
    }
}
