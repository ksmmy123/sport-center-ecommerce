<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table      = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'total_harga',
        'status',
        'bukti_transfer',
        'status_pembayaran',
        'status_pengiriman',
        'metode_pembayaran',
        'alamat_pengiriman',
        'ongkir',
        'biaya_layanan',
        'biaya_penanganan',
        'tgl_pesan',
        'rating',
        'ulasan',
        'balasan_admin',
    ];
}