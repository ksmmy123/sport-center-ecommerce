<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';

    // ✦ TAMBAHAN: merk, bahan, warna, berat — agar bisa diisi
    // melalui form admin (tambah/edit produk) dan mass-assignment lain.
    protected $allowedFields = [
        'nama_produk',
        'harga',
        'gambar',
        'category_id',
        'deskripsi',
        'diskon',
        'merk',
        'bahan',
        'warna',
        'berat',
    ];

    public function getProdukHome()
    {
        // Mengambil semua produk beserta nama kategorinya
        return $this->select('products.*, categories.nama_kategori')
                    ->join('categories', 'categories.id = products.category_id')
                    ->findAll();
    }
}