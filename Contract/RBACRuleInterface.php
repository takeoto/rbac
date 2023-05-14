<?php

namespace Takeoto\RBAC\Contract;

/** @todo ADVANCED [v2] */
interface RBACRuleInterface
{
    /**
     * Checks the data for correctness.
     *
     * @param mixed[] $data
     * @return bool
     */
    public function verify(array $data = []): bool;
}
