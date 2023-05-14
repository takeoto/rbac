<?php

declare(strict_types=1);

namespace Takeoto\RBAC\Implementation\Restriction;

use Takeoto\RBAC\Contract\RBACPermissionInterface;
use Takeoto\RBAC\Contract\RBACRestrictionInterface;
use Takeoto\RBAC\Contract\RBACStatusInterface;
use Takeoto\RBAC\RBACStatus;
use Takeoto\RBAC\Utility\Ensure;

class RBACRouteRestriction implements RBACRestrictionInterface
{
    public const NAME = 'system.route';
    public const PAYLOAD_PATH = 'route.path';
    public const PAYLOAD_METHOD = 'route.method';

    public function __construct(
        private readonly RBACPermissionInterface $permission
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function claimed(mixed $payload = null): RBACStatusInterface
    {
        $this->ensurePayload($payload);
        $allowed = $this->permission->getArguments()->get(self::PAYLOAD_PATH) === $payload;

        return new RBACStatus($allowed);
    }

    /**
     * Makes the permission key for the restriction.
     *
     * @param string $key
     * @return string
     */
    public static function makeKey(string $key): string
    {
        return implode('.', [
            self::NAME,
            $key,
        ]);
    }

    /**
     * Ensure that the payload is valid.
     *
     * @param mixed[] $payload
     * @return void
     * @throws \Exception
     */
    private function ensurePayload(mixed $payload): void
    {
        Ensure::string($payload);
    }
}
