# PROJECT REKAYASA PERANGKAT LUNAK

## BISA FOLOW ANGGOTA KELOMPOK
1. <a href="https://github.com/yuliusagungt"> Yulius Agung T. </a>
2. <a href="https://github.com/YudhaDevelops">FX. Bima Yudha P.</a>
3. <a href="https://github.com/jjoseph48">Josephin Diva A Verol.</a>
4. <a href="https://github.com/LaurensiaSim">Laurensia S.</a>
5. <a href="https://github.com/MikaelSasmita">Mikael Raditya A. S.</a>

# Software yang di pakai
- <a href="https://git-scm.com/downloads">GIT</a>
- <a href="https://getcomposer.org/download/">COMPOSER</a>
- <a href="https://www.apachefriends.org/download.html">XAMPP</a>
- <a href="https://code.visualstudio.com/Download">VISUAL STUDIO CODE</a>

## DONATE?
### OVO
<img src="https://i.ibb.co/ZSrhPMh/ovo.jpg" alt="ovo" border="0" width="400">

## Requirements
### Windows

1. > PHP 8.0 >=
2. > Nodejs 16.16.0 >=
3. > Composer 2.3.10 >=

## Hal yang perlu dilakukan sebelum menjalankan aplikasi

1. Pastiin dah nginstall aplikasi yang wajib di pakai di atas yang 3 komponen dari atas. Klk blom install bisa download install dulu.
2. Jalankan perintah pada gitbash `git clone https://github.com/YudhaDevelops/Project-RPL-Study.git` tunggu ampe selesai. Klk dah ada filenya di local buka gitbash trus jalankan perintah `git pull` tunggu ampe selesai.
3. Jalankan perintah `cd Project-RPL-Study`.
4. Jalankan perintah `cd back` klk mau jalanin servernya.
5. Jalankan perintah `code .` klk mau buka foldernya di vscode.
6. Jalankan perintah `composer install` dan `npm install` pada folder `Project-RPL-Study/back`.
7. Jalankan perintah `php artisan migrate` yang belom ada tabel nya sama sekali, kalau dah ada pake perintah `php artisan migrate:fresh` di folder `Project-RPL-Study/back`.

## Mau Push Tapi Bingung?

1. Pastiin posisi gitbash di dalem folder `Project-RPL-Study`.
2. Git pull dulu sebelumnya.
3. Klk ada conflict gak ada conflict bisa langsung jalankan perintah `git add .`.
4. Jalankan perintah `git commit -m "pesan commit" `.
5. Jalankan perintah `git push -u origin main` tunggu ampe selesai biasanya login pake browser klk yang blom login.

## Untuk menjalankan versi pengembangan
1. Jalankan `php artisan serve` pada folder `Project-RPL-Study/back`.

## Perintah Laravel yang sering di pake
1. `php artisan serve` jalanin server localnya.
2. `php artisan migrate` jalanin migrasi atau buat table dari laravel ke db nya.
3. `php artisan migrate:fresh` sama jalanin migrasi cuman dia udah ada tablenya di db.
4. `php artisan migrate:fresh --seed` perintah `--seed` buat jalanin seeder atau data dummy klk dibutuhkan ntar.
5. `php artisan make:controller NamaController` buat controller.
6. `php artisan make:model NamaModel` buat model atau penghubung table db dengan controller.
7. `php artisan make:model NamaModel -c -m` buat model, `-c` + buat controller sesuai nama model, `-m` + buat table migrasi di laravel untuk atur dari segi nama sampe tipe data di db. tambahan perintah bisa di sesuaikan kebutuhan gak harus semuanya di jalanin.
8. `php artisan make:migration namaMigrasiDatabase` buat table untuk ngatur dari entity sampe tipe data yang ada di db.
8. `composer install` buat download data vendor yang harus di perluin buat jalanin program (khusus yang habuis clone dari github).
