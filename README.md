<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

Dokumentasi ini memberikan ringkasan tentang proyek aplikasi sederhana untuk sharing foto. Di dalamnya terdapat informasi mengenai teknologi yang digunakan, list API routes dan instalasi environment variables.

## Project Overview
Project ini adalah aplikasi sederhana sharing foto yang memungkinkan pengguna untuk melakukan beberapa tindakan. Pengguna dapat melakukan login, melihat foto, mengunggah foto dengan caption dan tag, memperbarui detail foto, memberi suka atau tidak suka pada foto, serta menghapus foto.

## Technologies Used
- Laravel version 9 framework Backend
- PHP vesion 8
- Bootstrap version 5 framework Frontend
- Database MySQL
- Git for version control

## List API Routes
| Nama             | URL                  |  Method  | Deskripsi                                                    |
| ---------------- | ---------------------|----------| -------------------------------------------------------------|
| homepage         | /                    |   GET    | halaman pertama yang dilihat oleh pengunjung                 |
| register         | /register            |   GET    | halaman untuk membuat akun baru                              |
| register action  | /register/action     |   POST   | action dari halaman register                                 |
| login            | /login               |   GET    | halaman login dengan mekanisme email & password              |
| login action     | /login-action        |   POST   | action dari halaman login                                    |
| photos           | /photos              |   GET    | halaman utama & semua foto akan tampil (user berhasil login) |
| profil           | /profil              |   GET    | halaman profil user (berhasil login)                         |
| profil update    | /profil              |   POST   | action dari edit profil user (berhasil login)                |
| photos create    | /photos-create       |   GET    | halaman form create foto baru (berhasil login)               |
| photos create    | /photos              |   POST   | action yang dihasilkan dari halaman create foto baru tersebut| 
| action           |                      |          | (user berhasil login)                                        |
| photos detail    | /photos/:{id}        |   GET    | halaman data detail foto seperti caption, tag, author        |
| photos update    | /photos/:{id}        |   PUT    | action untuk memperbarui data foto (user berhasil login)     |
| photos delete    | /photos/:{id}        |  DELETE  | action untuk menghapus sebuah foto (user berhasil login)     |
| photos like      | /photos/:{id}/like   |   POST   | action untuk menyukai sebuah foto                            |
| photos unlike    | /photos/:{id}/unlike |   POST   | Menghapus action menyukai sebuah foto                        |


##  Installation Environment Variables
1). Cloning repository project atau download berupa file zip <br>
2). Buka direktori project lalu buka command line.<br>
3). Update composer <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;**$ composer update** <br>
4). Copy file .env.example <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;**$ cp .env.example .env** <br>
5). Buat database baru dengan nama **db_laravel** <br>
6). Setup database yang telah dibuat pada file .env <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;**DB_CONNECTION=mysql** <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;**DB_H&nbsp;OST=127.0.0.1**<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;**DB_PORT=3306**<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;**DB_DATABASE=db_laravel**<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;**DB_USERNAME=root**<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;**DB_PASSWORD=**<br>
7). Lakukan generate key <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;**$ php artisan key:generate**<br>
8). Jalankan migrate & seeder <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;**$ php artisan migrate --seed** <br>
9). Ubah tipe data kolom photo_profile pada tabel users dan photo pada tabel photos menjadi **LONGBLOB** <br>
10). Jalankan serve<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;**$ php artisan serve**<br>








## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
