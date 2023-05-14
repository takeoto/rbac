<?php

namespace Takeoto\RBAC\Restriction\Contract;

use Takeoto\RBAC\Contract\RBACPermissionInterface;

interface NeedPermissionInterface
{
    /**
     * Sets the permission.
     *
     * @param RBACPermissionInterface $permission
     * @return void
     */
    public function setPermission(RBACPermissionInterface $permission): void;
}
