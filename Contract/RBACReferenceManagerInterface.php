<?php

namespace Takeoto\RBAC\Contract;

/** @todo ADVANCED [v2] */
interface RBACReferenceManagerInterface
{
    /**
     * Makes the reference of object.
     *
     * @psalm-template T
     * @param class-string<T> $class
     * @param mixed[] $data
     * @return T
     */
    public function make(string $class, array $data);

    /**
     * Checks that item is a reference.
     *
     * @param RBACItemInterface $item
     * @return bool
     */
    public function has(RBACItemInterface $item): bool;

    /**
     * Adds the reference in the reference register.
     *
     * @param RBACItemInterface $item
     * @return void
     */
    public function register(RBACItemInterface $item): void;
}
