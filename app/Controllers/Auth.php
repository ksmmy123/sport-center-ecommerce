<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    // Menampilkan pilihan Login Admin atau Pelanggan
    public function index() {
        return view('auth/login_choice');
    }

    // Menampilkan form input username & password berdasarkan role yang dipilih
    public function inputPassword($role) {
        return view('auth/login_password', ['role' => $role]);
    }

    // Menampilkan halaman pendaftaran untuk customer baru
    public function register() {
        return view('auth/register');
    }

    public function proses_register() {
        $model = new UserModel();
        
        // Menarik seluruh input dari form register view (Password disimpan teks biasa)
        $data = [
            'username'       => $this->request->getPost('username'),
            'password'       => $this->request->getPost('password'), // Diubah: Tidak menggunakan hash lagi
            'role'           => 'pelanggan',
            'nama'           => $this->request->getPost('nama'),
            'no_hp'          => $this->request->getPost('no_hp'),
            'provinsi'       => $this->request->getPost('provinsi'),
            'kota'           => $this->request->getPost('kota'),
            'kecamatan'      => $this->request->getPost('kecamatan'),
            'desa'           => $this->request->getPost('desa'),
            'alamat_lengkap' => $this->request->getPost('alamat_lengkap'),
        ];

        // Proteksi double username
        $cek = $model->where('username', $data['username'])->first();
        if ($cek) {
            return redirect()->back()->withInput()->with('error', 'Username sudah digunakan!');
        }

        if ($model->insert($data)) {
            return redirect()->to(base_url('auth/inputPassword/pelanggan'))->with('success', 'Registrasi berhasil! Silakan login.');
        }
        return redirect()->back()->withInput()->with('error', 'Gagal mendaftar.');
    }

    public function attemptLogin()
    {
        $model = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $role_target = $this->request->getPost('role'); 

        $user = $model->where('username', $username)->first();

        // Mencocokkan password string teks biasa secara langsung
        if ($user && $password === $user['password']) {
            if ($user['role'] !== $role_target) {
                return redirect()->back()->with('error', 'Username tidak terdaftar sebagai ' . $role_target);
            }

            // Masukkan semua data identitas ke session
            session()->set([
                'id'             => $user['id'], 
                'username'       => $user['username'],
                'nama'           => $user['nama'],           
                'no_hp'          => $user['no_hp'],          
                'alamat_lengkap' => $user['alamat_lengkap'], 
                'kota'           => $user['kota'],           
                'role'           => $user['role'],
                'isLoggedIn'     => true
            ]);

            return redirect()->to($user['role'] == 'admin' ? '/admin/dashboard' : '/home');
        }
        return redirect()->back()->with('error', 'Username atau Password salah!');
    }

    public function logout()
{
    $session = session();
    $session->destroy();
    // Tambahkan baris ini untuk memastikan data benar-benar kosong di memori
    $session->remove(['id', 'username', 'nama', 'role', 'isLoggedIn']); 
    return redirect()->to(base_url('auth'))->with('success', 'Berhasil keluar.');
}
}