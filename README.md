# LearnGate - Platform Kursus Online Bahasa Inggris

### Deskripsi Singkat
LearnGate adalah platform pembelajaran online yang dibangun menggunakan Laravel 11 dengan Laravel Breeze untuk sistem autentikasi. Project ini mengimplementasikan konsep **Role-Based Access Control (RBAC)** dengan tiga role utama: Admin, Teacher, dan Student. Platform ini menyediakan fitur-fitur lengkap untuk manajemen kursus bahasa Inggris, mulai dari pendaftaran user dengan validasi email domain, pembuatan dan pengelolaan course oleh teacher, hingga sistem tracking progress pembelajaran untuk student. Aplikasi ini dibangun dengan arsitektur **Model-View-Controller (MVC)** dan menggunakan **Tailwind CSS** untuk tampilan yang modern dan responsive.

---

### Role & Permissions
- **Admin** memiliki full access ke semua fitur termasuk manage users (create, edit, delete), approve/reject teacher registrations, manage all courses, dan manage categories.
- **Teacher** memerlukan approval dari admin dengan email domain `@learngate.com`, dapat create & manage own courses, create & manage course contents, view student progress, dan tidak dapat delete account jika memiliki active courses.
- **Student** menggunakan email domain `@gmail.com` dengan auto-approved registration, dapat browse & enroll courses, view course materials, track learning progress, dan tidak bisa skip content (sequential learning).

---

### Fitur Berdasarkan Role
- **Admin Dashboard** menampilkan statistics (total users, teachers, students, courses), recent users dan courses, quick actions (create user, course, category), serta notifikasi pending teachers yang menunggu approval.
- **Teacher Page** menyediakan list semua courses yang dibuat, course management (edit, delete, toggle status), content management (add/edit/delete materials), student list dengan progress tracking, dan analytics (total students, completions, contents).
- **Student Page** menampilkan courses yang diikuti, progress tracking dengan percentage completion, continue learning (quick access ke materi selanjutnya), course catalog dengan search & filter, dan profile management dengan statistics.

---

### Testing Flows
1. Teacher Approval Flow
> - Register sebagai teacher dengan email @learngate.com
> - Login akan ditolak dengan notifikasi "pending approval"
> - Login sebagai admin → Teachers → Pending
> - Approve atau reject teacher
> - Teacher dapat login setelah di-approve

2. Course Enrollment Flow
> - Login sebagai student
> - Browse courses → Pilih course
> - Click "Enroll"
> - Akses materi pertama
> - Complete materi untuk unlock yang berikutnya

3. Content Management Flow
> - Login sebagai teacher
> - My Courses → Select course
> - Manage Contents → Add Content
> - Pilih type (text/file)
> - Upload file atau tulis text
> - Save dengan order number

---

## Instalasi
1. Clone Repository
``` bash
git clone https://github.com/naylazaky/LearnGate.git
cd learngate
```

2.  Install Dependencies
``` bash
composer install

npm install
```

3. Konfigurasi Database
``` env DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=learngate_db
DB_USERNAME=root
DB_PASSWORD=
```

4. Jalankan Migration & Seeder
``` bash
php artisan migrate

php artisan db:seed
```

5. Setup Storage
``` bash
php artisan storage:link
``` 

6. Jalankan
``` bash
npm run dev

php artisan serve
```

---

## Struktur Proyek
``` bash
learngate/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin controllers
│   │   │   ├── Auth/           # Authentication
│   │   │   ├── Student/        # Student controllers
│   │   │   └── Teacher/        # Teacher controllers
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   └── Models/                 # Eloquent models
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
├── public/
│   └── storage/               # Symlink ke storage
├── resources/
│   └── views/
│       ├── admin/             # Admin views
│       ├── auth/              # Auth views
│       ├── courses/           # Course views
│       ├── layouts/           # Layout templates
│       ├── profile/           # Profile views
│       ├── student/           # Student views
│       └── teacher/           # Teacher views
├── routes/
│   └── web.php               # Web routes
└── storage/
    └── app/
        └── public/
            ├── profile-photos/    # User photos
            └── course-contents/   # Course files
```
