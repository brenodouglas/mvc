<?php

namespace Base\Acl\Factory;

use Base\Acl\Interfaces\Factory\AclFactory as AclInterface;
use Base\Acl\Interfaces\RoleAble;
use Base\Acl\Role;
use Base\Acl\Acl;

/**
 * @author bdouglas <bdgoulasans@gmail.com>
 * @package ACL
 */
class AclFactory implements AclInterface
{
    public static function create(RoleAble $role)
    {
        $roles = new Role($role);
        $roles->hydratePage()->hydrateResource()->verifyIsAdmin();
        
        $acl = new Acl($roles);
        
        return $acl;
    }
}
