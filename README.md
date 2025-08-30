# Houzez Backend (Laravel API)

A **Real Estate Application Backend** built with **Laravel** that provides powerful and scalable **API endpoints** for managing real estate properties, agents, users, and more.  
This backend is designed to integrate seamlessly with the **Houzez real estate theme** or any front-end (React, Vue, Angular, or mobile apps).

---

## 🚀 Features
- 🔐 **Authentication & Authorization** (Laravel Sanctum/JWT)  
- 🏡 **Property Management** (CRUD endpoints for properties)  
- 👨‍💼 **Agents & Agencies Management**  
- 📑 **Property Search & Filters** (location, price, type, etc.)  
- 💰 **Membership Packages & Payments** (Stripe/PayPal)  
- 📍 **GeoIP & Location-based Search**  
- 📷 **Media Uploads** (property images, documents)  
- 📊 **Dashboard APIs** for analytics & reporting  
- 🌍 **Multi-language & Multi-currency Ready**  

---

## 📂 Project Structure
```
houzez-backend-laravel/
│── app/
│   ├── Http/Controllers/   # API Controllers
│   ├── Models/             # Eloquent Models
│   └── ...
│── routes/
│   └── api.php             # API Routes
│── database/
│   ├── migrations/         # DB Migrations
│   └── seeders/            # Sample Data
│── config/
│── .env.example            # Example Environment File
│── composer.json
│── README.md
```

---

## 🔧 Installation

### 1️⃣ Clone the repository
```bash
git clone https://github.com/your-username/houzez-backend-laravel.git
cd houzez-backend-laravel
```

### 2️⃣ Install dependencies
```bash
composer install
```

### 3️⃣ Setup environment
```bash
cp .env.example .env
php artisan key:generate
```
Configure your `.env` file:
```env
APP_NAME=HouzezAPI
APP_ENV=local
APP_KEY=base64:xxxxxx
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=houzez
DB_USERNAME=root
DB_PASSWORD=
```

### 4️⃣ Run migrations & seeders
```bash
php artisan migrate --seed
```

### 5️⃣ Start development server
```bash
php artisan serve
```
The API will be available at:  
👉 `http://127.0.0.1:8000/api`

---

## 📡 API Endpoints (Examples)

### Authentication
- `POST /api/register` → Register new user  
- `POST /api/login` → Login and get token  
- `POST /api/logout` → Logout  

### Properties
- `GET /api/properties` → List all properties  
- `GET /api/properties/{id}` → Get single property  
- `POST /api/properties` → Create new property  
- `PUT /api/properties/{id}` → Update property  
- `DELETE /api/properties/{id}` → Delete property  

### Agents
- `GET /api/agents` → List agents  
- `POST /api/agents` → Create new agent  

### Membership & Payments
- `GET /api/packages` → Get all membership plans  
- `POST /api/payments/checkout` → Process payment  

---

## 🧪 Testing
Run feature & unit tests:
```bash
php artisan test
```

---

## 📌 Roadmap
- [ ] Add GraphQL support  
- [ ] Advanced MLS/IDX integration  
- [ ] WebSocket real-time notifications  
- [ ] Admin panel (Laravel Nova/Filament)  

---

## 🤝 Contributing
Contributions are welcome! Please fork this repository and submit a pull request for any improvements.

---

## 📄 License
This project is licensed under the **MIT License**.
