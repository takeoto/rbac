<?php

declare(strict_types=1);

namespace Takeoto\RBAC\Restriction;

use Takeoto\RBAC\Contract\RBACPermissionInterface;
use Takeoto\RBAC\Contract\RBACRestrictionInterface;

class RBACByAttributeRestrictionBuilder extends AbstractRBACRestrictionBuilder
{
    public function __construct(
        private readonly string $attributeName
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function support(RBACPermissionInterface $permission): bool
    {
        return $permission->hasAttribute($this->attributeName)
            && isset($this->builders[$permission->getAttribute($this->attributeName)]);
    }

    /**
     * {@inheritDoc}
     */
    public function build(RBACPermissionInterface $permission): RBACRestrictionInterface
    {
        return $this->getRestriction($permission->getAttribute($this->attributeName), $permission);
    }
}
