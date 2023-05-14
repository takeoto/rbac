<?php

declare(strict_types=1);

namespace Takeoto\RBAC\Restriction;

use Takeoto\RBAC\Contract\RBACRestrictionInterface;
use Takeoto\RBAC\Contract\RBACStatusInterface;
use Takeoto\RBAC\RBACStatus;

class RBACAlwaysTrueRestriction implements RBACRestrictionInterface
{
    /**
     * {@inheritDoc}
     */
    public function claimed(mixed $payload = null): RBACStatusInterface
    {
        return new RBACStatus(true);
    }
}
