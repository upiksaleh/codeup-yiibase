<?php
/**
 * CodeUP Framework using Yii Framework
 * @author Upik Saleh <upxsal@gmail.com>
 * @license MIT
 */

namespace codeup\filters;

use app\core\UUser;
use Yii;

class AccessRule extends \yii\filters\AccessRule
{
    /**
     * @var array custom roles RBAC untuk codeup
     */
    public $codeup_user_roles = [];

    /**
     * @var array custom roles database field
     */
    public $codeup_role_field = [];

    /**
     * @var array codeup user group
     */
    public $codeup_user_groups = [];

    // --------------------------------------------------------------------

    /**
     * mengecek apakah user assigment role terdapat pada array codeup_user_roles
     * @param  [type] $user [description]
     * @return booelan       true jika terdapat, false jika tidak ada
     */
    private function codeupUserRoles($user)
    {
        if ($user->getIsGuest()) {
            return false;
        }
        $role_assigment_user = Yii::$app->getAuthManager()->getAssignments($user->getId());
        foreach ($this->codeup_user_roles as $item) {
            if (array_key_exists($item, $role_assigment_user)) {
                return true;
            }
        }
        return false;
    }

    // --------------------------------------------------------------------

    /**
     * mengecek apakah user group terdapat pada array codeup_user_groups
     * @param  [type] $user [description]
     * @return booelan       true jika terdapat, false jika tidak ada
     */
    private function codeupRoleField($user)
    {
        if ($user->getIsGuest()) {
            return false;
        }
        return UUser::hasRole($this->codeup_role_field);
//        $roles = Yii::$app->user->identity->getRole();
//        foreach($roles as $role) {
//            if (in_array($role, $this->codeup_role_field))
//                return true;
//        }
//        return false;
    }
    // --------------------------------------------------------------------

    /**
     * mengecek apakah user group terdapat pada array codeup_user_groups
     * @param  [type] $user [description]
     * @return booelan       true jika terdapat, false jika tidak ada
     */
    private function codeupUserGroups($user)
    {
        if ($user->getIsGuest()) {
            return false;
        }
        $usergroup = Yii::$app->user->identity->_group;
        if(in_array($usergroup, $this->codeup_user_groups))
            return true;
        return false;
    }

    // --------------------------------------------------------------------
    protected function matchRole($user)
    {
        if ($user === false) {
            throw new InvalidConfigException('The user application component must be available to specify roles in AccessRule.');
        }

        if (!empty($this->codeup_role_field))
            return $this->codeupRoleField($user);

        if (!empty($this->codeup_user_roles))
            return $this->codeupUserRoles($user);

        if (!empty($this->codeup_user_groups))
            return $this->codeupUserGroups($user);


        return parent::matchRole($user);


    }
}