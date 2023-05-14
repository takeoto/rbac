# rbac
The role base access control system [DRAFT]

```php

use Takeoto\RBAC\Contract\RBACPermissionInterface;
use Takeoto\RBAC\Contract\RBACRoleInterface;
use Takeoto\RBAC\Contract\RBACUserInterface;
use Takeoto\RBAC\Implementation\RBACDoctrineStorage;
use Takeoto\RBAC\Implementation\Restriction\RBACRouteRestriction;
use Takeoto\RBAC\Permission\RBACPermissionBuilder;
use Takeoto\RBAC\RBAC;
use Takeoto\RBAC\RBACBuilderProvider;
use Takeoto\RBAC\RBACManager;
use Takeoto\RBAC\Restriction\RBACAlwaysTrueRestriction;
use Takeoto\RBAC\Restriction\RBACByAttributeRestrictionBuilder;
use Takeoto\RBAC\Restriction\RBACByRegexpKeyRestrictionBuilder;
use Takeoto\RBAC\Restriction\RBACRestrictionProvider;
use Takeoto\RBAC\Role\RBACRoleBuilder;

$manager = new RBACManager(
    $storage = new RBACDoctrineStorage(),
    $builderProvider = new RBACBuilderProvider(),
);

$builderProvider->register(RBACRoleInterface::class, new RBACRoleBuilder($storage, $manager));
$builderProvider->register(RBACPermissionInterface::class, new RBACPermissionBuilder());

$attributeRestrictionBuilder = new RBACByAttributeRestrictionBuilder('type');
$attributeRestrictionBuilder->register('route', RBACRouteRestriction::class);

$regexpKeyRestrictionBuilder = new RBACByRegexpKeyRestrictionBuilder();
$regexpKeyRestrictionBuilder->register('/.*/', new RBACAlwaysTrueRestriction());

$restrictionProvider = new RBACRestrictionProvider();
$restrictionProvider->register($attributeRestrictionBuilder);
$restrictionProvider->register($regexpKeyRestrictionBuilder);

$rbac = new RBAC($restrictionProvider, $manager);

/** @var RBACUserInterface $user */
$user = '{ instance of RBACUserInterface }';
$rbac->check($user, 'some-permission-key', '{ some permission payload }');

```