# 🚀 Digital Twin Showcase Portal - Holicindo

Live Demo:
https://holicindo-demo.site

---

## 📌 Deskripsi Project

Digital Twin Showcase Portal adalah sistem berbasis web yang dirancang untuk mengelola unit showcase industri secara terstruktur. Sistem ini memungkinkan setiap klien memiliki akses terbatas terhadap unit miliknya, serta menyediakan fitur monitoring dan request service berbasis serial number.

---

## 🎯 Fitur Utama

### 🔐 Isolasi Data (Multi-Client)

- Setiap user hanya dapat melihat data miliknya
- Akses unit divalidasi menggunakan authorization (Policy)
- Proteksi terhadap akses manual URL (403 Forbidden)

---

### 🧾 Manajemen Showcase

- Serial number otomatis (HC-YYYY-XXX)
- Informasi spesifikasi teknis
- Status garansi dinamis

---

### 📱 Unit Passport (Mobile Friendly)

- Halaman detail unit berbasis mobile-first
- URL SEO-friendly:

    ```
    /unit/HC-2026-001
    ```

---

### 🛠 Request Service

- Pengguna dapat mengirim permintaan service
- Otomatis terhubung dengan serial number unit
- Data tersimpan di database
- Admin dapat memonitor request

---

## 🧱 Teknologi yang Digunakan

- Laravel 12
- Laravel Breeze
- Blade + Tailwind CSS
- MySQL

---

## 🔑 Kredensial Login

### Admin

- Email: [admin@mail.com](mailto:admin@mail.com)
- Password: password

### Client Coffee

- Email: [coffee@mail.com](mailto:coffee@mail.com)
- Password: password

### Client Chocolate

- Email: [choco@mail.com](mailto:choco@mail.com)
- Password: password

---

## 🔐 Penjelasan Isolasi Data

Sistem ini menerapkan isolasi data menggunakan Laravel Policy untuk memastikan setiap user hanya dapat mengakses data showcase miliknya berdasarkan relasi user_id. Setiap akses terhadap detail unit akan divalidasi melalui authorization sehingga apabila user mencoba mengakses unit milik klien lain melalui URL secara langsung, sistem akan menolak akses dengan response 403 Forbidden. Pendekatan ini menjamin keamanan dan pemisahan data antar klien dalam lingkungan multi-tenant.

---

## 📊 Catatan

Project ini dikembangkan sebagai bagian dari tes teknis untuk membangun portal B2B dengan fokus pada:

- keamanan data
- performa
- dan visibilitas SEO

---

## 👨‍💻 Developer

Teguh Bagas Mardiansyah
