# 📘 Project Requirement – Vietnam Lifestyle SuperAPI (Laravel + Boost)

---

## A. Tổng quan & Ý tưởng cốt lõi

* **Tên dự án:** Vietnam Lifestyle SuperAPI
* **Mục đích chính:** Tạo ra một hệ thống **SuperAPI đa dịch vụ**, tập hợp dữ liệu hữu ích cho đời sống (du lịch, sự kiện, ẩm thực, giao thông, giáo dục, tài chính), mở cho cộng đồng dev sử dụng.
* **Đối tượng người dùng:** Developer, startup nhỏ, cộng đồng open source.
* **Điểm khác biệt:**

  * Không chỉ là 1 API, mà là **nền tảng nhiều module**.
  * Có **Playground + Swagger Docs** để dev test trực tiếp.
  * **Laravel Boost** hỗ trợ AI code đồng nhất, tránh hard-code, theo chuẩn Filament 4.

---

## B. Luồng người dùng & Các trang chính

### Luồng người dùng

1. Developer → Landing page → Đăng ký → Nhận API Key.
2. Truy cập **Dashboard** để quản lý API Key, quota, usage log.
3. Xem **Docs (Swagger/Redoc)** và test API trên **Playground**.
4. Gọi API các module (Travel, Events, Recipes, Transport, Education, Finance).

### Các trang chính

* **Landing Page** – giới thiệu, docs, demo.
* **Signup/Login** – cấp API key.
* **Dashboard** – quản lý quota, usage.
* **API Docs** – Swagger/Redoc.
* **Playground** – test API trực tiếp.

---

## C. Module & Chức năng chi tiết

### 1. Travel & Local

* Địa điểm (id, tên, loại, địa chỉ, tọa độ, ảnh, review).
* Tìm kiếm theo từ khóa hoặc bán kính.
* Crowdsourced: user có thể POST địa điểm mới.

### 2. Events

* Sự kiện (id, tên, thời gian, địa điểm, RSVP).
* RSVP tham gia, subscribe.
* Real-time notify bằng **Laravel Echo**.

### 3. Recipes & Food

* Công thức nấu ăn (nguyên liệu, hướng dẫn, calories, ảnh/video).
* Filter theo nguyên liệu, chế độ ăn.
* Upload file lưu ở S3/Supabase.

### 4. Public Transport

* Tuyến bus/metro (id, tên, trạm, lịch trình).
* API geolocation tìm nearest station.
* Cron job update dữ liệu hằng ngày.

### 5. Education

* Đề thi, flashcard, quiz.
* Role-based (admin/teacher/student).
* Gamification: leaderboard, điểm.

### 6. Finance

* Giá vàng, ngoại tệ, xăng dầu.
* Cron sync dữ liệu mỗi giờ.
* Redis cache để giảm call.

---

## D. Giao diện & Look & Feel

* **Color Palette:**

  * Primary: `#2563EB` (blue-600)
  * Secondary: `#F59E0B` (amber-500)
  * Neutral: `#1E293B` (slate-800), `#F1F5F9` (slate-100)
* **Phong cách:** tối giản, hiện đại, giống Postman/Swagger UI.
* **Hiệu ứng:** hover smooth, transition 200ms, chart animation.
* **Responsive:**

  * Desktop: Sidebar trái (Docs, Playground, Dashboard).
  * Mobile: Menu gọn, Playground compact.

---

## E. Yêu cầu kỹ thuật

* **Backend:** Laravel 11/12 + PHP 8.2+
* **Frontend:** Next.js + Tailwind (Landing + Dashboard)
* **UI Lib:** shadcn/ui, lucide-react
* **API:** REST (JSON\:API) + optional GraphQL
* **Auth:** Laravel Sanctum / JWT (API Key)
* **DB:** PostgreSQL + Redis (cache, queue)
* **Jobs:** Laravel Queue (sync data, crawler)
* **Realtime:** Laravel Echo + Pusher/WebSocket
* **Storage:** S3 / Supabase Storage (ảnh/video)
* **Monitoring:** Laravel Telescope + Sentry
* **CI/CD:** GitHub Actions + Railway/Render/Vapor

---

# 📂 Folder Structure – Vietnam Lifestyle SuperAPI

```bash
app/
 ├── Console/              # Artisan commands
 ├── Exceptions/
 ├── Http/
 │    ├── Controllers/
 │    │     ├── Api/
 │    │     │     ├── V1/       # Controllers cho API v1
 │    │     │     │     ├── TravelController.php
 │    │     │     │     ├── EventController.php
 │    │     │     │     ├── RecipeController.php
 │    │     │     │     ├── TransportController.php
 │    │     │     │     ├── EducationController.php
 │    │     │     │     └── FinanceController.php
 │    │     │     └── V2/       # Controllers cho API v2 (khi nâng cấp)
 │    │     └── Web/            # Nếu có route web (Dashboard)
 │    ├── Middleware/
 │    ├── Requests/             # FormRequest validation
 │    └── Resources/Api/        # API Resource transformers (JSON:API)
 │
 ├── Models/
 │    ├── Travel.php
 │    ├── Event.php
 │    ├── Recipe.php
 │    ├── Transport.php
 │    ├── Education.php
 │    └── Finance.php
 │
 ├── Services/                  # Business logic tách khỏi Controller
 │    ├── TravelService.php
 │    ├── EventService.php
 │    ├── RecipeService.php
 │    ├── TransportService.php
 │    ├── EducationService.php
 │    └── FinanceService.php
 │
 ├── Repositories/              # Query logic (Eloquent/DB)
 │    ├── TravelRepository.php
 │    ├── EventRepository.php
 │    └── ...
 │
 ├── Rules/                     # Custom validation rules
 ├── Policies/                  # Authorization (Gate/Policy)
 └── Providers/                 # Service providers
```

---

# 📂 API Versioning

* **Routes**

```bash
routes/
 ├── api.php         # Chỉ include file version
 ├── api_v1.php      # Route cho V1
 └── api_v2.php      # Route cho V2
```

Ví dụ `routes/api.php`:

```php
Route::prefix('v1')->group(base_path('routes/api_v1.php'));
Route::prefix('v2')->group(base_path('routes/api_v2.php'));
```

---

# 📂 Config & Guidelines

```bash
config/
 ├── api.php            # Global API settings (rate limit, version)
 ├── boost.php          # Laravel Boost config
 └── modules.php        # Module toggle (bật/tắt module)
```

```bash
.ai/
 ├── guidelines/
 │     ├── form-rules.md       # Rule cho Filament Form
 │     ├── table-rules.md      # Rule cho Filament Table
 │     └── naming.md           # Naming convention
 ├── boost.json                # Config Laravel Boost MCP
 └── copilot-instructions.md   # Extra rule cho Copilot/Claude
```

---

# 🔑 Nguyên tắc quan trọng

1. **Không viết logic trong Controller** → Controller chỉ gọi Service.
2. **Service gọi Repository** → clean architecture.
3. **Validation** → dùng FormRequest trong `Http/Requests/`.
4. **Response** → luôn return `JsonResource` để đồng nhất.
5. **Versioning** → V1 stable, V2 thêm feature mới mà không phá cũ.
6. **Laravel Boost** → AI luôn tuân theo rule trong `.ai/guidelines/`.

---

# 📌 Ví dụ Endpoint V1 (Travel)

```php
// routes/api_v1.php
Route::prefix('travel')->group(function () {
    Route::get('/', [TravelController::class, 'index']);
    Route::post('/', [TravelController::class, 'store']);
    Route::get('/{id}', [TravelController::class, 'show']);
});
```

```php
// app/Http/Controllers/Api/V1/TravelController.php
class TravelController extends Controller
{
    public function index(Request $request, TravelService $service)
    {
        return TravelResource::collection($service->list($request->all()));
    }
}
```

```php
// app/Services/TravelService.php
class TravelService
{
    public function __construct(
        protected TravelRepository $repo
    ) {}

    public function list(array $filters)
    {
        return $this->repo->getFiltered($filters);
    }
}
```
