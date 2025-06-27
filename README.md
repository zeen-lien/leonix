# 🚀 Leonix - Aplikasi Manajemen Dokumen Pribadi & Aman

Leonix adalah aplikasi web modern berbasis Laravel 11 yang dirancang untuk menyimpan, mengelola, dan mengakses berkas dokumen secara praktis dan aman. Aplikasi ini menyediakan antarmuka dua peran utama, yaitu Admin dan Pengguna, serta dilengkapi dengan fitur autentikasi, pengelolaan file, dan antarmuka yang responsif untuk desktop maupun mobile.

## 🎯 Tujuan Utama

Menyediakan platform penyimpanan file pribadi yang bisa digunakan siapa saja untuk:

- ✅ Mengunggah dokumen dengan drag & drop
- ✅ Mengelola dokumen (arsip/sampah)
- ✅ Menjaga keamanan berkas pribadi
- ✅ Mengakses dokumen dari mana saja secara lokal
- ✅ Interface modern dengan tema gelap

## 👤 Role Pengguna

### Admin
- 🔧 Mengelola data pengguna (edit/hapus/ubah role)
- 📊 Melihat statistik pengguna dan file
- 🔍 Akses ke semua file
- 📱 Sidebar untuk navigasi, responsive menu mobile

### Pengguna Biasa
- 🏠 Dashboard pribadi
- 📤 Upload file dengan drag & drop
- 📁 Lihat file saya dengan preview
- 🗑️ Sampah file (trash bin)
- 👤 Profil pengguna
- 🚪 Logout

## 🧩 Fitur Utama

### 🔐 Autentikasi & Keamanan
- Register, Login, Logout
- Verifikasi password (dengan animasi show/hide)
- Reset password via email
- Remember me functionality
- Session management

### 📁 File Management
- Upload & manajemen file pribadi
- Drag & drop file upload
- File preview (PDF, image, text)
- File search & filter
- Bulk operations (select multiple files)
- Sistem "Sampah" (Trash bin) dengan soft delete
- File versioning

### 🎨 UI/UX Features
- Responsive layout (sidebar desktop, hamburger menu mobile)
- Desain tema gelap yang modern & elegan
- Glassmorphism effects
- Micro-interactions dan animations
- Skeleton loading states
- Toast notifications
- Modal dialogs dengan backdrop blur

### 📱 Responsive Design
- Desktop: Sidebar navigation
- Mobile: Toggle menu di kanan bawah
- Tablet: Adaptive layout
- Touch-friendly interface

## 🌐 Landing Page

Menampilkan:
- Deskripsi aplikasi yang menarik
- CTA untuk Register & Login
- Tampilan clean & informatif
- Animasi modern
- UI ramah pengguna

## 🛠️ Tech Stack

### Backend
- **Framework**: Laravel 11
- **Database**: MySQL
- **Web Server**: Laragon (local)
- **Auth**: Laravel Breeze
- **Storage**: Local (default Laravel storage/app/public)
- **Queue**: Laravel Queue + Redis (optional)
- **Search**: Laravel Scout (optional)

### Frontend
- **Template Engine**: Blade
- **CSS Framework**: Tailwind CSS
- **JavaScript**: Alpine.js
- **Build Tool**: Vite
- **Icons**: Heroicons
- **Animations**: AOS (Animate On Scroll)

### Development Tools
- **Version Control**: Git + GitHub
- **Package Manager**: Composer + NPM
- **Code Quality**: Laravel Pint
- **Testing**: PHPUnit

## 📁 Project Structure

```
leonix/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── FileController.php
│   │   │   └── ProfileController.php
│   │   └── Middleware/
│   ├── Models/
│   │   ├── User.php
│   │   └── File.php
│   └── Services/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   ├── auth/
│   │   ├── dashboard/
│   │   ├── files/
│   │   ├── layouts/
│   │   └── components/
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php
│   └── admin.php
└── storage/
    └── app/
        └── public/
            └── files/
```

## 🚀 Installation & Setup

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL
- Laragon (recommended)

### Installation Steps

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd leonix
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Storage Setup**
   ```bash
   php artisan storage:link
   ```

6. **Build Assets**
   ```bash
   npm run dev
   ```

7. **Start Development Server**
   ```bash
   php artisan serve
   ```

## 🎨 Design System

### Color Palette (Dark Theme)
- **Primary**: `#3B82F6` (Blue)
- **Secondary**: `#8B5CF6` (Purple)
- **Background**: `#0F172A` (Dark Blue)
- **Surface**: `#1E293B` (Slate)
- **Text**: `#F1F5F9` (Light Gray)
- **Accent**: `#10B981` (Green)

### Typography
- **Font Family**: Inter (Google Fonts)
- **Headings**: Font weight 600-700
- **Body**: Font weight 400-500

### Components
- **Cards**: Glassmorphism with backdrop blur
- **Buttons**: Gradient backgrounds with hover effects
- **Inputs**: Dark theme with focus states
- **Modals**: Backdrop blur with smooth animations

## 📋 Development Roadmap

### Phase 1: Core Features ✅
- [x] Project setup & structure
- [ ] Authentication system
- [ ] Basic file upload
- [ ] User dashboard
- [ ] Admin panel

### Phase 2: Enhanced Features 🚧
- [ ] Drag & drop file upload
- [ ] File preview system
- [ ] Search & filter
- [ ] Trash bin system
- [ ] Responsive design

### Phase 3: Advanced Features 📅
- [ ] File versioning
- [ ] Bulk operations
- [ ] File sharing
- [ ] Advanced search
- [ ] Analytics dashboard

### Phase 4: Performance & Security 📅
- [ ] File encryption
- [ ] Caching system
- [ ] API endpoints
- [ ] Performance optimization
- [ ] Security hardening

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Author

**Leonix Team**
- Email: contact@leonix.com
- GitHub: [@leonix-team](https://github.com/leonix-team)

---

⭐ **Star this repository if you find it helpful!**
