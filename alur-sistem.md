# Alur Sistem Aplikasi App Tracker

## 1. Login
- User mengakses halaman login.
- User memasukkan email dan password.
- Sistem melakukan autentikasi menggunakan Laravel Jetstream/Fortify.
- Jika berhasil, user diarahkan ke dashboard sesuai role dan hak akses.

## 2. Navigasi Menu
- Setelah login, user melihat menu di sidebar sesuai role dan permission (can_view, can_create, can_edit, can_delete).
- Menu yang tampil hanya yang diizinkan oleh role user (dinamis).

## 3. Manajemen Data Master
- User dengan hak akses dapat mengelola master data:
    - **User**: CRUD pengguna, assign role dan departemen.
    - **Role**: CRUD role, atur hak akses menu (can_view, can_create, can_edit, can_delete).
    - **Menu**: CRUD menu aplikasi (khusus super admin/developer).
    - **Departemen**: CRUD departemen (jika diaktifkan).

## 4. Transaksi Surat Jalan (Delivery Order)
- User memilih menu "Manajemen Surat Jalan".
- User dapat:
    - Melihat daftar surat jalan (dengan fitur pencarian dan paginasi).
    - Menambah surat jalan baru (jika punya can_create).
    - Edit/hapus surat jalan (jika punya can_edit/can_delete).
- Setiap aksi CRUD akan tercatat di audit log.

## 5. Upload Bukti Serah Terima (Delivery Order Receipt)
- User memilih menu "Upload Proof".
- User dapat:
    - Melihat daftar bukti serah terima.
    - Menambah bukti baru (hanya untuk surat jalan yang belum ada bukti, upload foto, isi nama penerima, tanggal terima).
    - Edit/hapus bukti (jika punya can_edit/can_delete).
- Satu surat jalan hanya bisa punya satu bukti serah terima.
- File foto disimpan di storage dan path dicatat di database.
- Semua aksi tercatat di audit log.

## 6. Scan Barcode (Opsional)
- User memilih menu "Scan Barcode".
- User dapat scan barcode surat jalan menggunakan kamera.
- Sistem mencari surat jalan berdasarkan kode unik.
- Jika ditemukan, detail surat jalan ditampilkan.

## 7. Audit Log
- Semua perubahan data (create, update, delete) dicatat otomatis oleh sistem (LogObserver).
- Super admin dapat melihat log lengkap di menu "Log".

## 8. Selesai Transaksi
- Setelah transaksi (misal: upload bukti serah terima) selesai, data dapat dilihat di daftar dan log audit.
- User dapat logout dari aplikasi.

---

**Catatan:**
- Semua fitur dan menu tunduk pada sistem role & permission yang diatur di menu Role.
- UI dan aksi hanya muncul jika user punya hak akses sesuai permission.
- Sistem mendukung audit trail dan keamanan berbasis policy & middleware.
