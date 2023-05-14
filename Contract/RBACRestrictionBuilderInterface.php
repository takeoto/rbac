<?php

namespace Takeoto\RBAC\Contract;

interface RBACRestrictionBuilderInterface
{
    /**
     * Verifies that the builder can create a constraint on the permission.
     *
     * @param RBACPermissionInterface $permission
     * @return bool
     */
    public function support(RBACPermissionInterface $permission): bool;

    /**
     * Builds the restriction on the permission.
     *
     * @param RBACPermissionInterface $permission
     * @return RBACRestrictionInterface
     */
    public function build(RBACPermissionInterface $permission): RBACRestrictionInterface;
}
