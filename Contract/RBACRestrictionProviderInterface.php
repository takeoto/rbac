<?php

namespace Takeoto\RBAC\Contract;

interface RBACRestrictionProviderInterface
{
    /**
     * Gets the restriction on the permission.
     *
     * @param RBACPermissionInterface $permission
     * @return RBACRestrictionInterface
     */
    public function for(RBACPermissionInterface $permission): RBACRestrictionInterface;
}
