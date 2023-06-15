<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusModel extends Model
{
    protected $table = 'status';

    public function index()
    {
      return $this->select(['id','status'])->get()->getResultArray();
    }
}