<?php
namespace App\Controllers;
use App\Models\ProductModel;

class Product extends BaseController {
    
    public function index() {
        $model = new ProductModel();
        $data = [
            'title' => 'Sport Precision',
            'products' => $model->findAll()
        ];
        return view('user/home', $data);
    }

    public function tambah() {
        // Menampilkan form tambah produk
        return view('admin/produk_tambah'); 
    }

    public function edit($id) {
        $model = new ProductModel();
        
        // Ambil data produk berdasarkan ID agar form edit terisi
        $data['product'] = $model->find($id);

        if (!$data['product']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Produk dengan ID $id tidak ditemukan");
        }

        return view('admin/produk_edit', $data); 
    }
}