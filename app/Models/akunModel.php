<?php

namespace App\Models;

use CodeIgniter\Model;

class akunModel extends Model
{

    protected $useTimestamps = true;

    protected $db, $builder;

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
    }


    public function getAkun()
    {

        $this->builder->select('users.id as userid, username, email, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $query = $this->builder->get()->getResult();

        return $query;
    }

    public function getAkunid()
    {
        $this->builder->select('users.id as userid, username, auth_groups.id as groupsid, name, group_id, user_id');
        $this->builder->join('users', 'users.id = auth_groups_users.user_id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $query = $this->builder->get()->getResult();

        return $query;
    }
}
