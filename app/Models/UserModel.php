<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // WAJIB DIDAFTARKAN DI SINI SUPAYA TIDAK NILAI NULL LAGI
    protected $allowedFields    = [
        'username', 
        'nama', 
        'password', 
        'role', 
        'provinsi', 
        'kota', 
        'kecamatan', 
        'desa', 
        'alamat_lengkap', 
        'no_hp'
    ];
}