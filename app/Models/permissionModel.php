<?php

namespace App\Models;

use CodeIgniter\Model;

class permissionModel extends Model
{

    protected $useTimestamps = true;

    protected $db, $builder;

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('auth_groups_users');
    }


    public function getPermission()
    {

        $this->builder->select('users.id as userid, username, auth_groups.id as groupsid, name, group_id, user_id');
        $this->builder->join('users', 'users.id = auth_groups_users.user_id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $query = $this->builder->get()->getResult();

        return $query;
    }

    public function getAkunid()
    {
    }
}
