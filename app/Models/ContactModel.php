<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactModel extends Model
{
    protected $table            = 'contacts';
    protected $primaryKey       = 'id_contact';
    protected $returnType       = 'object';
    protected $allowedFields    = ['name_contact', 'name_alias', 'phone', 'email', 'address', 'info_contact', 'id_group'];
    protected $useTimestamps    = true;
    protected $useSoftDeletes   = false;

    function getAll()
    {
        $builder = $this->db->table('contacts');
        $builder->join('group_data', 'group_data.id_group = contacts.id_group');
        $query = $builder->get();
        return $query->getResult();
    }
}
