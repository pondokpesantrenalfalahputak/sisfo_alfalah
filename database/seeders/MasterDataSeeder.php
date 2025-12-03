<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\KelasSantri;
use App\Models\Guru;
use App\Models\Santri;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MasterDataSeeder extends Seeder
{
    /**
     * Jalankan seed database.
     */
    public function run(): void
    {
        // ----------------------------------------------------
        // 1. BUAT AKUN ADMIN & WALI SANTRI
        // ----------------------------------------------------

        // Admin Utama
        User::create([
            'name' => 'Admin Utama SISFO',
            'email' => 'admin@alfalah.com',
            'password' => Hash::make('password'), // Password default: password
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        $this->command->info('Admin Utama berhasil dibuat. Email: admin@alfalah.com, Pass: password');

        // Wali Santri 1
        $wali1 = User::create([
            'name' => 'Bapak Budi Hartono',
            'email' => 'budi@wali.com',
            'password' => Hash::make('password'),
            'role' => 'wali_santri',
            'email_verified_at' => now(),
        ]);
        $this->command->info('Wali Santri 1 berhasil dibuat. Email: budi@wali.com, Pass: password');

        // Wali Santri 2
        $wali2 = User::create([
            'name' => 'Ibu Siti Aisyah',
            'email' => 'siti@wali.com',
            'password' => Hash::make('password'),
            'role' => 'wali_santri',
            'email_verified_at' => now(),
        ]);
        $this->command->info('Wali Santri 2 berhasil dibuat. Email: siti@wali.com, Pass: password');


        // ----------------------------------------------------
        // 2. MASTER DATA (KELAS DAN GURU)
        // ----------------------------------------------------

        $kelas_data = [
            ['nama_kelas' => 'VII A', 'tingkat' => 'SMP'],
            ['nama_kelas' => 'VIII B', 'tingkat' => 'SMP'],
            ['nama_kelas' => 'X IPA', 'tingkat' => 'SMA'],
        ];
        foreach ($kelas_data as $data) {
            KelasSantri::create($data);
        }
        $kelas = KelasSantri::all();
        $this->command->info('3 Kelas Santri berhasil dibuat.');

        Guru::create([
            'nama_lengkap' => 'Ust. Ahmad Dahlan',
            'nuptk' => '1234567890',
            'jabatan' => 'Guru Agama & Wali Kelas VII A',
            'no_hp' => '08123456789',
        ]);
        $this->command->info('1 Data Guru berhasil dibuat.');


        // ----------------------------------------------------
        // 3. DATA SANTRI
        // ----------------------------------------------------

        // Santri 1 (Milik Wali 1)
        // Catatan: Pastikan kolom 'wali_santri_id' di tabel santris sudah ada
        $santri1 = Santri::create([
            'wali_santri_id' => $wali1->id,
            'kelas_id' => $kelas->where('nama_kelas', 'VII A')->first()->id,
            'nama_lengkap' => 'Rizky Pratama',
            'nisn' => '0012345678',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2010-01-15',
            'alamat' => 'Jl. Merdeka No. 10',
        ]);
        $this->command->info('Santri Rizky Pratama berhasil dibuat.');

        // Santri 2 (Milik Wali 1)
        $santri2 = Santri::create([
            'wali_santri_id' => $wali1->id,
            'kelas_id' => $kelas->where('nama_kelas', 'VIII B')->first()->id,
            'nama_lengkap' => 'Dewi Lestari',
            'nisn' => '0023456789',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2009-05-20',
            'alamat' => 'Jl. Sudirman No. 25',
        ]);
        $this->command->info('Santri Dewi Lestari berhasil dibuat.');

        // Santri 3 (Milik Wali 2)
        $santri3 = Santri::create([
            'wali_santri_id' => $wali2->id,
            'kelas_id' => $kelas->where('nama_kelas', 'X IPA')->first()->id,
            'nama_lengkap' => 'Fahri Hidayat',
            'nisn' => '0034567890',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '2007-11-03',
            'alamat' => 'Perumahan Indah Blok C',
        ]);
        $this->command->info('Santri Fahri Hidayat berhasil dibuat.');


        // ----------------------------------------------------
        // 4. CONTOH TAGIHAN (DIPERBAIKI)
        // ----------------------------------------------------

        $tanggalTagihan = Carbon::now()->toDateString(); // Tanggal hari ini
        $jatuhTempoBulanIni = Carbon::now()->addDays(15)->toDateString();
        $jatuhTempoBulanLalu = Carbon::now()->subMonth()->addDays(15)->toDateString();

        // Tagihan 1 (SPP - Santri 1 - BELUM LUNAS)
        Tagihan::create([
            'santri_id' => $santri1->id,
            'jenis_tagihan' => 'SPP',
            'jumlah_tagihan' => 550000.00,
            'tanggal_tagihan' => $tanggalTagihan, // ✅ Ditambahkan
            'tanggal_jatuh_tempo' => $jatuhTempoBulanIni,
            'keterangan' => 'SPP Bulan ' . Carbon::now()->translatedFormat('F Y'),
            'status' => 'Belum Lunas',
        ]);

        // Tagihan 2 (Galon - Santri 2 - BELUM LUNAS)
        Tagihan::create([
            'santri_id' => $santri2->id,
            'jenis_tagihan' => 'Galon',
            'jumlah_tagihan' => 50000.00,
            'tanggal_tagihan' => $tanggalTagihan, // ✅ Ditambahkan
            'tanggal_jatuh_tempo' => $jatuhTempoBulanIni,
            'status' => 'Belum Lunas',
        ]);

        // Tagihan 3 (Uang Pembangunan - Santri 3 - LUNAS)
        Tagihan::create([
            'santri_id' => $santri3->id,
            'jenis_tagihan' => 'Uang Pembangunan',
            'jumlah_tagihan' => 1000000.00,
            'tanggal_tagihan' => $tanggalTagihan, // ✅ Ditambahkan
            'tanggal_jatuh_tempo' => $jatuhTempoBulanLalu,
            'status' => 'Lunas',
        ]);

        $this->command->info('3 Contoh Tagihan (2 Belum Lunas, 1 Lunas) berhasil dibuat.');
    }
}