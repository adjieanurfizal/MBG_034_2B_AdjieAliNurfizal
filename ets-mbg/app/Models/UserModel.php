<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user'; // Nama tabel di DB
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'password', 'role'];
}