# 🌐 Vietnam Lifestyle SuperAPI

Vietnam Lifestyle SuperAPI là một hệ thống **đa dịch vụ (multi-module API)** được xây dựng trên **Laravel**. Dự án này được thiết kế để vừa hữu ích cho cộng đồng, vừa thể hiện khả năng thiết kế hệ thống phức tạp theo chuẩn production.

---

## 📖 Documentation

Toàn bộ tài liệu chi tiết được đặt trong folder [`docs/`](./docs/):

* [Requirements](./docs/requirements.md) – Mô tả tổng quan dự án, module, tech stack, flow.
* [Database Schema](./docs/database_schema.md) – ERD + migration mẫu cho 6 module.
* [Guidelines Index](./docs/README_guidelines.md)

  * [Form Rules](./docs/guidelines/form_rules.md)
  * [Table Rules](./docs/guidelines/table_rules.md)
  * [Naming Conventions](./docs/guidelines/naming.md)

👉 Các guideline này cũng được copy vào folder `.ai/` để **Laravel Boost** và AI agent (Copilot, Claude, Cursor) đọc trực tiếp.

---

## 🚀 Features

* **Travel & Local** – API địa điểm, review, crowdsourcing.
* **Events** – API sự kiện, RSVP, real-time notify.
* **Recipes** – API công thức nấu ăn, filter theo ingredient.
* **Public Transport** – API tuyến xe bus/metro, geolocation search.
* **Education** – API quiz, flashcard, gamification.
* **Finance** – API giá vàng, ngoại tệ, xăng dầu (cron sync).

---

## 🛠️ Tech Stack

* **Backend:** Laravel 11/12, PHP 8.2+
* **Database:** PostgreSQL, Redis (cache, queue)
* **Auth:** Laravel Sanctum / JWT
* **Realtime:** Laravel Echo + WebSocket
* **Storage:** S3 / Supabase Storage
* **CI/CD:** GitHub Actions + Railway/Render/Vapor
* **AI Boost:** Laravel Boost (MCP + Guidelines)

---

## 📂 Project Structure

```bash
superapi/
├── app/               # Code chính
├── config/            # Config
├── database/          # Migrations, seeders
├── routes/            # API v1, v2
├── docs/              # 📖 Documentation
├── .ai/               # AI Guidelines cho Laravel Boost
├── tests/             # Unit & Feature tests
└── README.md          # File này
```

---

## 🔑 Getting Started

```bash
# 1. Clone repo
 git clone https://github.com/yourname/superapi.git
 cd superapi

# 2. Cài dependencies
 composer install
 npm install && npm run build

# 3. Copy .env
 cp .env.example .env
 php artisan key:generate

# 4. Migrate DB
 php artisan migrate --seed

# 5. Chạy server
 php artisan serve
```

Docs chi tiết về API endpoint có trong [`docs/requirements.md`](./docs/requirements.md) và sẽ được mở rộng với OpenAPI/Swagger.

---

## 🤝 Contributing

* Xem [Guidelines](./docs/README_guidelines.md) trước khi code.
* Pull request cần theo **commit convention** và pass tất cả test.

---

## 📜 License

MIT © 2025 – Vietnam Lifestyle SuperAPI
