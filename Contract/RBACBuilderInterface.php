<?php

namespace Takeoto\RBAC\Contract;

/**
 * @template T
 */
interface RBACBuilderInterface
{
    /**
     * Builds the item with params.
     *
     * @param mixed $params
     * @return T
     */
    public function build(mixed $params = null);

    /**
     * Verifies whether the item can be built with parameters.
     *
     * @param mixed $params
     * @return bool
     */
    public function verify(mixed $params = null): bool;
}
