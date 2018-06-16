<?php
/**
 * Created by PhpStorm.
 * User: dangkhoa
 * Date: 6/11/18
 * Time: 03:18
 */

namespace App\Helper;


use App\User;

class CheckAccess
{
    public static function check($userId, $permission){
        try {
            $permissions = User::with('role.permissions')
                ->find($userId)['role']['permissions'];
            if (is_array($permissions)) {
                $permissions = $permissions->pluck('name')->toArray();
                return in_array($permission, $permissions, true);
            } else {
                return $permissions[0]->name === $permission;
            }
        } catch(\Exception $e) {
            return false;
        }
    }
}
