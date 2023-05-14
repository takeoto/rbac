<?php

namespace Takeoto\RBAC\Contract;

/** @todo ADVANCED [v2] */
interface RBACRulesProviderInterface
{
    /**
     * Gets the rule for the data.
     *
     * @param mixed[] $data
     * @return RBACRuleInterface
     */
    public function for(array $data): RBACRuleInterface;
}
