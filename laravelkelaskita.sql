-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Feb 2023 pada 14.51
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravelkelaskita`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `articles`
--

CREATE TABLE `articles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `thumbnail_image_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `articles`
--

INSERT INTO `articles` (`id`, `title`, `author_id`, `thumbnail_image_name`, `content`, `created_at`, `updated_at`) VALUES
(1, 'Website XII-RPL Telah Dibuka!', 1, 'article1.jpg', 'Officia magnam minus blanditiis ut reiciendis voluptatem corrupti. Omnis magni aut et amet. Consequatur velit officiis tenetur provident distinctio. Aperiam est quia animi repellendus molestias. Saepe fuga cum explicabo quam qui. Quasi aperiam sit ut iste in.', NULL, NULL),
(2, 'Cara Melihat Jadwal Pelajaran', 1, 'article2.jpg', 'Et ut vel voluptates dolor a neque. Quis vitae tempore alias. Quos consectetur dicta voluptatem quasi a enim. Ipsa at et in dolores. Corporis quod molestiae non ipsum dolorum perferendis.', NULL, NULL),
(3, 'Fitur-fitur Website Kelaskita', 1, 'article3.jpg', 'Quibusdam expedita ducimus qui ratione. Sequi vel sint nisi. Hic ut explicabo ex. Ducimus ratione amet ut. Veniam qui hic commodi.', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `days`
--

CREATE TABLE `days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `days`
--

INSERT INTO `days` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Senin', NULL, NULL),
(2, 'Selasa', NULL, NULL),
(3, 'Rabu', NULL, NULL),
(4, 'Kamis', NULL, NULL),
(5, 'Jumat', NULL, NULL),
(6, 'Sabtu', NULL, NULL),
(7, 'Minggu', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_05_11_042659_create_students_table', 1),
(5, '2020_05_11_043055_create_subjects_table', 1),
(6, '2020_05_11_043056_create_days_table', 1),
(7, '2020_05_11_043227_create_schedules_table', 1),
(8, '2020_05_11_043649_create_articles_table', 1),
(9, '2020_05_11_043705_create_settings_table', 1),
(10, '2020_05_12_072944_create_pickets_table', 1),
(11, '2020_05_12_073624_add_foreign_pickets', 1),
(12, '2023_01_16_123105_add_email_column_to_users_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pickets`
--

CREATE TABLE `pickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `day_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `day_id` bigint(20) UNSIGNED NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `schedules`
--

INSERT INTO `schedules` (`id`, `subject_id`, `day_id`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '06:30:00', '08:00:00', NULL, NULL),
(2, 2, 1, '08:00:00', '09:30:00', NULL, NULL),
(3, 3, 1, '10:00:00', '11:30:00', NULL, NULL),
(4, 4, 1, '13:00:00', '15:00:00', NULL, NULL),
(5, 5, 2, '06:30:00', '08:00:00', NULL, NULL),
(6, 6, 2, '08:00:00', '09:30:00', NULL, NULL),
(7, 7, 2, '10:00:00', '11:30:00', NULL, NULL),
(8, 8, 2, '13:00:00', '15:00:00', NULL, NULL),
(9, 9, 3, '06:30:00', '08:00:00', NULL, NULL),
(10, 10, 3, '08:00:00', '09:30:00', NULL, NULL),
(11, 11, 3, '10:00:00', '11:30:00', NULL, NULL),
(12, 1, 3, '13:00:00', '15:00:00', NULL, NULL),
(13, 4, 4, '06:30:00', '08:00:00', NULL, NULL),
(14, 3, 4, '08:00:00', '09:30:00', NULL, NULL),
(15, 6, 4, '10:00:00', '11:30:00', NULL, NULL),
(16, 7, 4, '13:00:00', '15:00:00', NULL, NULL),
(17, 2, 5, '06:30:00', '08:00:00', NULL, NULL),
(18, 6, 5, '08:00:00', '09:30:00', NULL, NULL),
(19, 9, 5, '10:00:00', '11:30:00', NULL, NULL),
(20, 11, 5, '13:00:00', '15:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'WEB_TITLE', 'Kelaskita', NULL, NULL),
(2, 'WEB_LOGO_WHITE', 'logo_white.png', NULL, NULL),
(3, 'WEB_LOGO', 'logo.png', NULL, NULL),
(4, 'WEB_FAVICON', 'favicon.png', NULL, NULL),
(5, 'HERO_TEXT_HEADER', 'Selamat Datang di', NULL, NULL),
(6, 'HERO_TEXT_DESCRIPTION', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quas deserunt, tenetur fuga fugiat quisquam recusandae quo sit eligendi nostrum. Maxime illo possimus necessitatibus natus totam.', NULL, NULL),
(7, 'HERO_BACKGROUND_IMAGE', 'bersama2.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `students`
--

INSERT INTO `students` (`id`, `name`, `image_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Ahmad Saugi', 'ahmad-saugi.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et nibh facilisis, accumsan tellus id, imperdiet nisl. Quisque ac est purus. Sed tempus venenatis maximus. Donec posuere ex sit amet quam accumsan, et semper purus efficitur. Donec ut ante in lacus faucibus dignissim at commodo lorem. Phasellus id neque orci. Fusce tempus erat justo, vel fringilla leo efficitur sed. Pellentesque non condimentum ligula. Praesent placerat, arcu vel elementum scelerisque, turpis urna tincidunt massa, malesuada aliquet lectus augue ac sem. Aenean vehicula quam augue, in pellentesque enim tincidunt dictum. Pellentesque vulputate lacus vitae dolor sollicitudin pellentesque.\n\nVestibulum ligula nibh, volutpat eget sodales vitae, ullamcorper vel risus. Aliquam risus velit, accumsan tincidunt eros ullamcorper, volutpat egestas diam. Aliquam erat volutpat. Morbi iaculis sem elementum leo sollicitudin, vitae sagittis neque facilisis. Vivamus consequat, odio ac sagittis varius, libero turpis pulvinar lorem, quis tempor lorem urna condimentum elit. Pellentesque vestibulum luctus ex nec scelerisque. Donec aliquet ut neque eget egestas. In cursus enim a sem vehicula, sit amet sollicitudin lacus lacinia. Nam interdum mi vel nisl viverra accumsan. Duis porta, ligula at venenatis condimentum, tellus quam dapibus quam, eget elementum nulla nisl nec mi. Integer scelerisque interdum risus, fringilla pulvinar libero rutrum gravida. Curabitur odio tortor, mollis in pharetra id, viverra eu ante. Nullam nec nulla mi. Integer mollis pellentesque gravida. Sed felis quam, luctus at est vitae, suscipit egestas nisi.\n\nAenean at est tristique, commodo dui quis, venenatis tellus. Aenean mattis maximus mi sit amet facilisis. Sed vel nibh sed metus finibus placerat. Praesent aliquam est eu est ultricies, vel aliquam dolor vulputate. Nam auctor justo eget mauris bibendum iaculis. Curabitur sodales dui non turpis aliquet, eu ultricies sapien mattis. Suspendisse aliquet nulla ut imperdiet varius. Phasellus laoreet mi augue, a lobortis elit sodales placerat. Donec rhoncus nulla ac risus eleifend, non semper ex vehicula. In hac habitasse platea dictumst. Vestibulum ut blandit arcu. Aenean efficitur varius porta. Suspendisse elit erat, dapibus vehicula maximus at, lobortis a eros. ', NULL, NULL),
(2, 'Adha Pratama', 'adha-pratama.jpeg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et nibh facilisis, accumsan tellus id, imperdiet nisl. Quisque ac est purus. Sed tempus venenatis maximus. Donec posuere ex sit amet quam accumsan, et semper purus efficitur. Donec ut ante in lacus faucibus dignissim at commodo lorem. Phasellus id neque orci. Fusce tempus erat justo, vel fringilla leo efficitur sed. Pellentesque non condimentum ligula. Praesent placerat, arcu vel elementum scelerisque, turpis urna tincidunt massa, malesuada aliquet lectus augue ac sem. Aenean vehicula quam augue, in pellentesque enim tincidunt dictum. Pellentesque vulputate lacus vitae dolor sollicitudin pellentesque.\n\nVestibulum ligula nibh, volutpat eget sodales vitae, ullamcorper vel risus. Aliquam risus velit, accumsan tincidunt eros ullamcorper, volutpat egestas diam. Aliquam erat volutpat. Morbi iaculis sem elementum leo sollicitudin, vitae sagittis neque facilisis. Vivamus consequat, odio ac sagittis varius, libero turpis pulvinar lorem, quis tempor lorem urna condimentum elit. Pellentesque vestibulum luctus ex nec scelerisque. Donec aliquet ut neque eget egestas. In cursus enim a sem vehicula, sit amet sollicitudin lacus lacinia. Nam interdum mi vel nisl viverra accumsan. Duis porta, ligula at venenatis condimentum, tellus quam dapibus quam, eget elementum nulla nisl nec mi. Integer scelerisque interdum risus, fringilla pulvinar libero rutrum gravida. Curabitur odio tortor, mollis in pharetra id, viverra eu ante. Nullam nec nulla mi. Integer mollis pellentesque gravida. Sed felis quam, luctus at est vitae, suscipit egestas nisi.\n\nAenean at est tristique, commodo dui quis, venenatis tellus. Aenean mattis maximus mi sit amet facilisis. Sed vel nibh sed metus finibus placerat. Praesent aliquam est eu est ultricies, vel aliquam dolor vulputate. Nam auctor justo eget mauris bibendum iaculis. Curabitur sodales dui non turpis aliquet, eu ultricies sapien mattis. Suspendisse aliquet nulla ut imperdiet varius. Phasellus laoreet mi augue, a lobortis elit sodales placerat. Donec rhoncus nulla ac risus eleifend, non semper ex vehicula. In hac habitasse platea dictumst. Vestibulum ut blandit arcu. Aenean efficitur varius porta. Suspendisse elit erat, dapibus vehicula maximus at, lobortis a eros. ', NULL, NULL),
(3, 'Rezky Sulihin', 'rezky-sulihin.jpeg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et nibh facilisis, accumsan tellus id, imperdiet nisl. Quisque ac est purus. Sed tempus venenatis maximus. Donec posuere ex sit amet quam accumsan, et semper purus efficitur. Donec ut ante in lacus faucibus dignissim at commodo lorem. Phasellus id neque orci. Fusce tempus erat justo, vel fringilla leo efficitur sed. Pellentesque non condimentum ligula. Praesent placerat, arcu vel elementum scelerisque, turpis urna tincidunt massa, malesuada aliquet lectus augue ac sem. Aenean vehicula quam augue, in pellentesque enim tincidunt dictum. Pellentesque vulputate lacus vitae dolor sollicitudin pellentesque.\n\nVestibulum ligula nibh, volutpat eget sodales vitae, ullamcorper vel risus. Aliquam risus velit, accumsan tincidunt eros ullamcorper, volutpat egestas diam. Aliquam erat volutpat. Morbi iaculis sem elementum leo sollicitudin, vitae sagittis neque facilisis. Vivamus consequat, odio ac sagittis varius, libero turpis pulvinar lorem, quis tempor lorem urna condimentum elit. Pellentesque vestibulum luctus ex nec scelerisque. Donec aliquet ut neque eget egestas. In cursus enim a sem vehicula, sit amet sollicitudin lacus lacinia. Nam interdum mi vel nisl viverra accumsan. Duis porta, ligula at venenatis condimentum, tellus quam dapibus quam, eget elementum nulla nisl nec mi. Integer scelerisque interdum risus, fringilla pulvinar libero rutrum gravida. Curabitur odio tortor, mollis in pharetra id, viverra eu ante. Nullam nec nulla mi. Integer mollis pellentesque gravida. Sed felis quam, luctus at est vitae, suscipit egestas nisi.\n\nAenean at est tristique, commodo dui quis, venenatis tellus. Aenean mattis maximus mi sit amet facilisis. Sed vel nibh sed metus finibus placerat. Praesent aliquam est eu est ultricies, vel aliquam dolor vulputate. Nam auctor justo eget mauris bibendum iaculis. Curabitur sodales dui non turpis aliquet, eu ultricies sapien mattis. Suspendisse aliquet nulla ut imperdiet varius. Phasellus laoreet mi augue, a lobortis elit sodales placerat. Donec rhoncus nulla ac risus eleifend, non semper ex vehicula. In hac habitasse platea dictumst. Vestibulum ut blandit arcu. Aenean efficitur varius porta. Suspendisse elit erat, dapibus vehicula maximus at, lobortis a eros. ', NULL, NULL),
(4, 'Virdio Samuel', 'virdio-samuel.jpeg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et nibh facilisis, accumsan tellus id, imperdiet nisl. Quisque ac est purus. Sed tempus venenatis maximus. Donec posuere ex sit amet quam accumsan, et semper purus efficitur. Donec ut ante in lacus faucibus dignissim at commodo lorem. Phasellus id neque orci. Fusce tempus erat justo, vel fringilla leo efficitur sed. Pellentesque non condimentum ligula. Praesent placerat, arcu vel elementum scelerisque, turpis urna tincidunt massa, malesuada aliquet lectus augue ac sem. Aenean vehicula quam augue, in pellentesque enim tincidunt dictum. Pellentesque vulputate lacus vitae dolor sollicitudin pellentesque.\n\nVestibulum ligula nibh, volutpat eget sodales vitae, ullamcorper vel risus. Aliquam risus velit, accumsan tincidunt eros ullamcorper, volutpat egestas diam. Aliquam erat volutpat. Morbi iaculis sem elementum leo sollicitudin, vitae sagittis neque facilisis. Vivamus consequat, odio ac sagittis varius, libero turpis pulvinar lorem, quis tempor lorem urna condimentum elit. Pellentesque vestibulum luctus ex nec scelerisque. Donec aliquet ut neque eget egestas. In cursus enim a sem vehicula, sit amet sollicitudin lacus lacinia. Nam interdum mi vel nisl viverra accumsan. Duis porta, ligula at venenatis condimentum, tellus quam dapibus quam, eget elementum nulla nisl nec mi. Integer scelerisque interdum risus, fringilla pulvinar libero rutrum gravida. Curabitur odio tortor, mollis in pharetra id, viverra eu ante. Nullam nec nulla mi. Integer mollis pellentesque gravida. Sed felis quam, luctus at est vitae, suscipit egestas nisi.\n\nAenean at est tristique, commodo dui quis, venenatis tellus. Aenean mattis maximus mi sit amet facilisis. Sed vel nibh sed metus finibus placerat. Praesent aliquam est eu est ultricies, vel aliquam dolor vulputate. Nam auctor justo eget mauris bibendum iaculis. Curabitur sodales dui non turpis aliquet, eu ultricies sapien mattis. Suspendisse aliquet nulla ut imperdiet varius. Phasellus laoreet mi augue, a lobortis elit sodales placerat. Donec rhoncus nulla ac risus eleifend, non semper ex vehicula. In hac habitasse platea dictumst. Vestibulum ut blandit arcu. Aenean efficitur varius porta. Suspendisse elit erat, dapibus vehicula maximus at, lobortis a eros. ', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Matematika', NULL, NULL),
(2, 'Bahasa Indonesia', NULL, NULL),
(3, 'Bahasa Inggris', NULL, NULL),
(4, 'Bahasa Jepang', NULL, NULL),
(5, 'IPA', NULL, NULL),
(6, 'IPS', NULL, NULL),
(7, 'PPKN', NULL, NULL),
(8, 'Pendidikan Agama', NULL, NULL),
(9, 'Pemrograman Web', NULL, NULL),
(10, 'Pemrograman Android', NULL, NULL),
(11, 'Basis Data', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `email`) VALUES
(1, 'Administrator', 'admin', NULL, '$2y$10$3IBkcRa8HhRW98Jp5YCeBOJYmcQ2UlA5/Yh8M.zKRc/KJzlW2zrL6', NULL, '2023-02-21 06:45:40', '2023-02-21 06:45:40', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `articles_author_id_foreign` (`author_id`);

--
-- Indeks untuk tabel `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `pickets`
--
ALTER TABLE `pickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pickets_day_id_foreign` (`day_id`),
  ADD KEY `pickets_student_id_foreign` (`student_id`);

--
-- Indeks untuk tabel `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_subject_id_foreign` (`subject_id`),
  ADD KEY `schedules_day_id_foreign` (`day_id`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `days`
--
ALTER TABLE `days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `pickets`
--
ALTER TABLE `pickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `pickets`
--
ALTER TABLE `pickets`
  ADD CONSTRAINT `pickets_day_id_foreign` FOREIGN KEY (`day_id`) REFERENCES `days` (`id`),
  ADD CONSTRAINT `pickets_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Ketidakleluasaan untuk tabel `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_day_id_foreign` FOREIGN KEY (`day_id`) REFERENCES `days` (`id`),
  ADD CONSTRAINT `schedules_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
