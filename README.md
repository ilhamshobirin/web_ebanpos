# web_ebanpos
this web to provide E-Paper Content and create notification for E-Banpos Mobile App

## Access to Panel
- akses sshnya ini kak

banpo9808
pass: banposapp

- akses ftp
admin_banpos
pass: banposapp

admin : 103.127.133.205:8090
username : banposapp
pass : BanposApp123

- panel
103.127.133.205:8090

admin
pass: go1Y1No7PgwKSzMN

https://banposdigital.web.id/storage/epaper_sample.pdf

## Hapus File menggunakan terminal
rm -r folder_yang_ingin_dihapus

*Hapus folder dengan menggunakan perintah rm dengan opsi -r untuk menghapus secara rekursif dan -f untuk memaksa penghapusan tanpa meminta konfirmasi.

## Membuat storage link pada cpanel
ln -s folder_yang_dituju folder_alias 
e.g. ln -s web_ebanpos/storage/app/public storage
<!-- e.g. ln -s web_ebanpos/public/storage storage -->