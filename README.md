# Velocity Berita 6

Version: 2.0.0

Child theme portal berita untuk induk `velocity` (demo: https://berita6.velocitydeveloper.com/).

## Perubahan 2.0.0

- Tidak lagi memakai Kirki: semua pengaturan pindah ke Customizer bawaan WordPress. Nama setting tetap sama, jadi isian lama (iklan, sosmed, warna, kategori beranda) langsung terbaca.
- Latar halaman dari field Kirki lama dipindah otomatis (sekali jalan) ke menu **Background** induk.
- Slider Posts Home 1 memakai CSS scroll-snap + JS kecil tanpa jQuery (Slick dari CDN dihapus).
- Ikon Font Awesome diganti SVG; tombol sosmed & cari tampil juga di HP; ikon X (Twitter) dan TikTok.
- Gambar memakai `srcset`, gambar utama carousel/artikel dimuat lebih dulu, gambar kosong memakai `img/no-image.webp`.
- Perbaikan: kategori di widget **Berita 6 Posts** kini benar-benar menyaring, urutan terpopuler tetap memuat artikel tanpa meta `hit`, pilihan **Nonaktifkan** menyembunyikan blok beranda, kategori **Big Carousel Home** dipakai, breadcrumb arsip menampilkan kategori yang dibuka, tombol bagikan tidak bergantung plugin, tidak ada gulir samping di HP.
- Hitungan tayangan (`hit`) dari tema hanya berjalan bila velocity-addons tidak aktif (velocity-addons sudah menghitungnya).
- Halaman pencarian & penulis memakai tampilan arsip.

## Customizer

**Berita** (panel)

- **Warna** — Warna Tema (pita, judul blok, tombol, hover link).
- **Iklan** — gambar + link untuk 10 slot: Header (728x90), Home 1 & 2 (650x70), Home Bawah 1 & 2 (600x80), Single 1–3 (650x70), Archive 1 & 2 (600x60). Slot tanpa gambar tidak tampil.
- **Sosial Media** — Facebook, X (Twitter), Instagram, Youtube, TikTok. Link kosong = ikon disembunyikan.
- **Home** — kategori Big Carousel Home; judul + kategori Posts Home 1 (slider) dan Posts Home 2 (1 besar + 4 kecil). Pilih **Nonaktifkan** untuk menyembunyikan blok.

Menu induk yang tetap dipakai: **Background** (latar halaman, bawaan #f1f1f1), **Layout** (posisi sidebar), **Identitas Situs** (logo).

## Widget

- **Berita 6 Posts** — judul, style 1–5, kategori, urutan (terbaru/terpopuler), jumlah.
- **Berita 6 Tabs** — tab Populer, Komentar, Tag.

Susunan demo: Main Sidebar = Gambar 300x250, Posts (style 3), Posts (style 4), Tabs, Gambar 300x250, Posts (style 1). Footer 1–3 = Recent Posts, Kategori, Kalender.

## Menu

Lokasi **primary** = menu utama (kategori berita).
