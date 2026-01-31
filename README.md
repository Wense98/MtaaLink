# MtaaLink™ - Neighborhood Service Marketplace

MtaaLink is a premium, localized service marketplace designed for the Tanzanian market. It connects skilled workers (fundis, cleaners, technicians) with customers in their neighborhoods (Mitaa), featuring a secure escrow payment system (Mtaa Pay™), real-time chats, and a trust-based review system.

## 🚀 Key Features

- **Mtaa Pay™ Protection**: Secure escrow system where funds are held until the job is confirmed.
- **Mtaa Pulse™**: Live neighborhood activity feed showing local hires and community engagement.
- **Mtaa Shield™**: Integrated verification system for workers, including background checks and portfolio audits.
- **Real-time Chat**: Direct communication between customers and pros.
- **Marketplace (Mtaa Market)**: Customers can post public jobs for workers to bid on.
- **Support Centre**: Direct support line for users to contact platform administrators.
- **Dual Language Support**: Full experience in both English and Swahili.

## 🛠️ Technology Stack

- **Backend**: Laravel 12.x
- **Frontend**: Blade, Alpine.js, Tailwind CSS
- **Database**: MySQL / PostgreSQL
- **Payments**: Integrated Escrow Simulation (Mpesa, Tigopesa, etc.)
- **Security**: Role-based Access Control (Admin, Worker, Customer)

## 📦 Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/yourusername/mtaalink.git
   cd mtaalink
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Setup environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run migrations & seeders**:
   ```bash
   php artisan migrate --seed
   ```

5. **Start the development server**:
   ```bash
   php artisan serve
   npm run dev
   ```

## 🛡️ Admin Access
To create an administrative user, you can run the provided script or use the `create_admin.php` utility.

---
Built with ❤️ by Antigravity for the MtaaLink Community.