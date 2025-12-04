-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 03 Des 2025 pada 11.48
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sisfo_alfalah_putak`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi_harians`
--

CREATE TABLE `absensi_harians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `santri_id` bigint(20) UNSIGNED NOT NULL,
  `wali_input_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_absensi` date NOT NULL,
  `jenis_kegiatan` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `absensi_harians`
--

INSERT INTO `absensi_harians` (`id`, `santri_id`, `wali_input_id`, `tanggal_absensi`, `jenis_kegiatan`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-12-02', 'Subuh', 'Izin', NULL, '2025-12-02 13:37:57', '2025-12-02 13:37:57'),
(3, 1, 1, '2025-12-03', 'Subuh', 'Alfa', NULL, '2025-12-03 00:27:42', '2025-12-03 00:27:42'),
(4, 1, 1, '2025-12-03', 'Dzuhur', 'Sakit', NULL, '2025-12-03 00:43:17', '2025-12-03 00:43:17'),
(5, 1, 1, '2025-12-03', 'Duha', 'Alfa', NULL, '2025-12-03 00:56:42', '2025-12-03 00:56:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi_rekapitulasi`
--

CREATE TABLE `absensi_rekapitulasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `santri_id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `wali_input_id` bigint(20) UNSIGNED NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `ngaji_alpha` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `sholat_alpha` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `roan_alpha` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gurus`
--

CREATE TABLE `gurus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `nuptk` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) NOT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas_santris`
--

CREATE TABLE `kelas_santris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kelas` varchar(255) NOT NULL,
  `tingkat` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kelas_santris`
--

INSERT INTO `kelas_santris` (`id`, `nama_kelas`, `tingkat`, `created_at`, `updated_at`) VALUES
(4, '7', '7', '2025-12-02 08:33:19', '2025-12-02 08:33:19'),
(5, '8', '8', '2025-12-02 08:33:54', '2025-12-02 08:33:54'),
(6, '9', '9', '2025-12-02 08:34:02', '2025-12-02 08:34:02'),
(7, '10', '10', '2025-12-02 08:34:11', '2025-12-02 08:34:11'),
(8, '11', '11', '2025-12-02 08:34:19', '2025-12-02 08:34:19'),
(9, '12', '12', '2025-12-02 08:34:27', '2025-12-02 08:34:27'),
(10, 'MUTAKHORIJIN/AT', '13', '2025-12-02 08:34:41', '2025-12-02 08:34:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(49, '0001_01_01_000000_create_users_table', 1),
(50, '0001_01_01_000001_create_cache_table', 1),
(51, '0001_01_01_000002_create_jobs_table', 1),
(52, '2025_12_01_032713_create_gurus_table', 1),
(53, '2025_12_01_032713_create_kelas_santris_table', 1),
(54, '2025_12_01_032713_create_santris_table', 1),
(55, '2025_12_01_032714_create_pembayarans_table', 1),
(56, '2025_12_01_032714_create_tagihans_table', 1),
(57, '2025_12_01_042856_create_pengumumen_table', 1),
(58, '2025_12_01_044944_create_rekenings_table', 1),
(59, '2025_12_01_054157_add_columns_to_pembayarans_table', 1),
(60, '2025_12_01_055118_add_foreign_keys_to_pembayarans_table', 1),
(61, '2025_12_01_191557_create_absensi_rekapitulasi_table', 1),
(62, '2025_12_02_063329_add_kategori_to_pengumumen_table', 1),
(63, '2025_12_02_070953_rename_rekenings_table_to_rekening_banks', 1),
(64, '2025_12_02_070954_add_rekening_bank_id_to_pembayarans_table', 1),
(65, '2025_12_02_070954_make_wali_santri_id_nullable_on_santris_table', 1),
(66, '2025_12_02_090035_update_kelas_id_on_santris_table', 1),
(67, '2025_12_03_000000_create_absensi_harians_table', 1),
(68, '2025_12_03_072112_update_status_column_length_in_absensi_harians_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayarans`
--

CREATE TABLE `pembayarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tagihan_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah_bayar` decimal(15,2) NOT NULL,
  `metode_pembayaran` varchar(100) NOT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `status_konfirmasi` enum('Menunggu','Dikonfirmasi','Ditolak') NOT NULL DEFAULT 'Menunggu',
  `tanggal_bayar` timestamp NULL DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rekening_bank_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumumen`
--

CREATE TABLE `pengumumen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `isi` text NOT NULL,
  `tanggal_publikasi` date NOT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengumumen`
--

INSERT INTO `pengumumen` (`id`, `judul`, `kategori`, `isi`, `tanggal_publikasi`, `status`, `created_at`, `updated_at`) VALUES
(1, 'LIBURAN', NULL, 'LKJHGFDSXDFTYUILOGFDFGHJHFGFRFGHJ,MHGTHKYKTY', '2025-12-03', 'published', '2025-12-03 02:04:23', '2025-12-03 02:04:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekening_banks`
--

CREATE TABLE `rekening_banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_bank` varchar(255) NOT NULL,
  `nomor_rekening` varchar(255) NOT NULL,
  `atas_nama` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rekening_banks`
--

INSERT INTO `rekening_banks` (`id`, `nama_bank`, `nomor_rekening`, `atas_nama`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'SEABANK', '2345678', 'NANDA BAGUS SETIAWAN', NULL, '2025-12-03 01:36:16', '2025-12-03 01:36:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `santris`
--

CREATE TABLE `santris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wali_santri_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kelas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `nisn` varchar(255) NOT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `santris`
--

INSERT INTO `santris` (`id`, `wali_santri_id`, `kelas_id`, `nama_lengkap`, `nisn`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 'Rizky Pratama', '0012345678', 'Bandung', '2010-01-15', 'Jl. Merdeka No. 10', '2025-12-02 08:31:33', '2025-12-02 12:10:48'),
(2, 2, NULL, 'Dewi Lestari', '0023456789', 'Jakarta', '2009-05-20', 'Jl. Sudirman No. 25', '2025-12-02 08:31:33', '2025-12-02 08:31:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2VJN1jReNxvdvykTIf4zr5EmN2P1ovUE3nyXLzpu', 1, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 12; Pixel 6 Build/SQ3A.220705.004; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/142.0.0.0 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/407.0.0.0.65;]', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibGRZNkdlQmpMRTBwZFd6UlczWmxRM2tSTGFqOUhoejhRbEVUYXkxbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9hYnNlbnNpLWJhcnUvNyI7czo1OiJyb3V0ZSI7czozNDoiYWRtaW4uYWJzZW5zaV9iYXJ1LnNlbGVjdF9hY3Rpdml0eSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1764756193),
('uD9DE9UMTc7jfwQRVajPh6Zl8CGq1zmJ95uEco4D', 2, '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibXV0UG15Slo3TGNQM2tRQ0FaeTZNVWc3SW5yaE5laDRuUDQwVUdtZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC93YWxpL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoxNDoid2FsaS5kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1764748860);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihans`
--

CREATE TABLE `tagihans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `santri_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_tagihan` date NOT NULL,
  `jenis_tagihan` enum('SPP','Galon','Denda','Uang Kas','Uang Pembangunan') NOT NULL,
  `jumlah_tagihan` decimal(10,2) NOT NULL,
  `tanggal_jatuh_tempo` date NOT NULL,
  `status` enum('Belum Lunas','Lunas') NOT NULL DEFAULT 'Belum Lunas',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tagihans`
--

INSERT INTO `tagihans` (`id`, `santri_id`, `tanggal_tagihan`, `jenis_tagihan`, `jumlah_tagihan`, `tanggal_jatuh_tempo`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-12-02', 'SPP', 550000.00, '2025-12-17', 'Belum Lunas', 'SPP Bulan Desember 2025', '2025-12-02 08:31:33', '2025-12-02 08:31:33'),
(2, 2, '2025-12-02', 'Galon', 50000.00, '2025-12-17', 'Belum Lunas', NULL, '2025-12-02 08:31:33', '2025-12-02 08:31:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','wali_santri') NOT NULL DEFAULT 'wali_santri',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Utama SISFO', 'admin@alfalah.com', '2025-12-02 08:31:32', '$2y$12$6zoFzi.9f2TKGRdr9yRb4.Y1HhhZRuy2sa8c3GcMwumnhr9pjW8q2', 'admin', NULL, '2025-12-02 08:31:32', '2025-12-02 08:31:32'),
(2, 'Bapak Budi Hartono', 'budi@wali.com', '2025-12-02 08:31:32', '$2y$12$A2fiYYmvoV2m7.X65MX4rONg4bbgOeJyau3UZpkp6mNzmHpOQAcdq', 'wali_santri', NULL, '2025-12-02 08:31:32', '2025-12-02 08:31:32'),
(3, 'Ibu Siti Aisyah', 'siti@wali.com', '2025-12-02 08:31:33', '$2y$12$joPyL2.FIurruQLBrQcg4OAtw1vuK3tbVTyQT59adjIvDVFh6NgTi', 'wali_santri', NULL, '2025-12-02 08:31:33', '2025-12-02 08:31:33');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi_harians`
--
ALTER TABLE `absensi_harians`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `absensi_harians_santri_id_tanggal_absensi_jenis_kegiatan_unique` (`santri_id`,`tanggal_absensi`,`jenis_kegiatan`),
  ADD KEY `absensi_harians_wali_input_id_foreign` (`wali_input_id`);

--
-- Indeks untuk tabel `absensi_rekapitulasi`
--
ALTER TABLE `absensi_rekapitulasi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `absensi_rekapitulasi_santri_id_bulan_tahun_unique` (`santri_id`,`bulan`,`tahun`),
  ADD KEY `absensi_rekapitulasi_kelas_id_foreign` (`kelas_id`),
  ADD KEY `absensi_rekapitulasi_wali_input_id_foreign` (`wali_input_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `gurus`
--
ALTER TABLE `gurus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gurus_nuptk_unique` (`nuptk`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelas_santris`
--
ALTER TABLE `kelas_santris`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kelas_santris_nama_kelas_unique` (`nama_kelas`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayarans_tagihan_id_foreign` (`tagihan_id`),
  ADD KEY `pembayarans_user_id_foreign` (`user_id`),
  ADD KEY `pembayarans_rekening_bank_id_foreign` (`rekening_bank_id`);

--
-- Indeks untuk tabel `pengumumen`
--
ALTER TABLE `pengumumen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `rekening_banks`
--
ALTER TABLE `rekening_banks`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `santris`
--
ALTER TABLE `santris`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `santris_nisn_unique` (`nisn`),
  ADD KEY `santris_wali_santri_id_foreign` (`wali_santri_id`),
  ADD KEY `santris_kelas_id_foreign` (`kelas_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `tagihans`
--
ALTER TABLE `tagihans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tagihans_santri_id_foreign` (`santri_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi_harians`
--
ALTER TABLE `absensi_harians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `absensi_rekapitulasi`
--
ALTER TABLE `absensi_rekapitulasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `gurus`
--
ALTER TABLE `gurus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kelas_santris`
--
ALTER TABLE `kelas_santris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT untuk tabel `pembayarans`
--
ALTER TABLE `pembayarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengumumen`
--
ALTER TABLE `pengumumen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `rekening_banks`
--
ALTER TABLE `rekening_banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `santris`
--
ALTER TABLE `santris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tagihans`
--
ALTER TABLE `tagihans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi_harians`
--
ALTER TABLE `absensi_harians`
  ADD CONSTRAINT `absensi_harians_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `santris` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensi_harians_wali_input_id_foreign` FOREIGN KEY (`wali_input_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `absensi_rekapitulasi`
--
ALTER TABLE `absensi_rekapitulasi`
  ADD CONSTRAINT `absensi_rekapitulasi_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas_santris` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensi_rekapitulasi_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `santris` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensi_rekapitulasi_wali_input_id_foreign` FOREIGN KEY (`wali_input_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD CONSTRAINT `pembayarans_rekening_bank_id_foreign` FOREIGN KEY (`rekening_bank_id`) REFERENCES `rekening_banks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pembayarans_tagihan_id_foreign` FOREIGN KEY (`tagihan_id`) REFERENCES `tagihans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembayarans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `santris`
--
ALTER TABLE `santris`
  ADD CONSTRAINT `santris_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas_santris` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `santris_wali_santri_id_foreign` FOREIGN KEY (`wali_santri_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `tagihans`
--
ALTER TABLE `tagihans`
  ADD CONSTRAINT `tagihans_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `santris` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
