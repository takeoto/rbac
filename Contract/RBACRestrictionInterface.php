<?php

namespace Takeoto\RBAC\Contract;

interface RBACRestrictionInterface
{
    /**
     * Checks the permission by the payload.
     *
     * @param mixed $payload
     * @return RBACStatusInterface
     */
    public function claimed(mixed $payload = null): RBACStatusInterface;
}
