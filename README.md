## Project Info

This is a project which is built and designed, tested for Tester Course at Codestar Academy.

### Technology Stack

-   PHP (v8.1.5)
-   composer (v2.3.5)
-   Laravel 9.0
-   MySQL 8.0

### Common Known Issues


### How to deploy
1. Cài đặt vendor
- Chạy lệnh:
```
composer install
```
- Với thư viện `maatwebsite/excel`, nếu bạn bị lỗi do phiên bản PHP 8.1 sẽ phải chạy một câu lệnh khác để cài đăt thư viện
- chạy lệnh:
```
composer require psr/simple-cache:^2.0 maatwebsite/excel
```

2. Cài đặt file .env
- Ta copy file `.env.example` và đổi tên thành `.env`
- config để kết nối với database:
```
DB_CONNECTION= tên hệ quả trị cơ sở dữ liệu || vd: mysql, mongoDB, ...
DB_HOST=127.0.0.1 || Host mặc định
DB_PORT=3306 || Port mặc định
DB_DATABASE= Tên database
DB_USERNAME= Tên đăng nhập database
DB_PASSWORD= Mật khẩu đăng nhập
```

3. Chạy lệnh để tạo bảng dữ liệu và dữ liệu
- Chạy lệnh tạo bảng:
```
php artisan migrate
```

- Chạy lệnh để tạo dữ liệu:
```
php artisan db:seed
```

4. Chạy server trên localhost:
```
php artisan serve
```

### Accounts
-   Admin default account -> email: admin@gmail.com
                            password: 12345678
-   Account AdminCodeStar -> email: admin@codestar.vn
                            password: codestar`ddmmyyyy` || vd: codestar20092022
