<?php

namespace Takeoto\RBAC\Contract;

interface RBACStatusInterface
{
    /**
     * Gets the current status condition.
     *
     * @return bool
     */
    public function isAllowed(): bool;

    /**
     * Gets the current status errors.
     *
     * @return string[]
     */
    public function getErrors(): array;
}
