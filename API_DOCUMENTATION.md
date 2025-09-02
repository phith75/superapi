# 🚀 Vietnam Lifestyle SuperAPI - API Documentation

## 📋 Tổng quan
**Vietnam Lifestyle SuperAPI** là một RESTful API cung cấp thông tin về cuộc sống tại Việt Nam, bao gồm 6 modules chính với tổng cộng **33 API endpoints**.

- **Base URL:** `http://127.0.0.1:8000/api/v1`
- **Version:** v1
- **Authentication:** Chưa implement (có thể thêm sau)
- **Response Format:** JSON với structure nhất quán

---

## 🏗️ Architecture
```
Controller → Service → Repository → Model
    ↓           ↓         ↓        ↓
   Routes    Business   Data    Database
            Logic     Access
```

---

## 📚 Modules & Endpoints

### 1. 🏖️ **Travel Module** - Địa điểm du lịch
**Base Path:** `/api/v1/travel`

| Method | Endpoint | Description | Request Body | Response |
|--------|----------|-------------|--------------|----------|
| `GET` | `/` | Danh sách địa điểm du lịch | Query: `?category=restaurant` | List of travels |
| `POST` | `/` | Tạo địa điểm mới | Travel data | Created travel |
| `GET` | `/{id}` | Chi tiết địa điểm | - | Travel details |
| `PUT` | `/{id}` | Cập nhật địa điểm | Update data | Updated travel |
| `DELETE` | `/{id}` | Xóa địa điểm (soft delete) | - | 204 No Content |

**Filters:**
- `category`: `restaurant`, `cafe`, `museum`, `park`, `other`

**Sample Request Body:**
```json
{
  "name": "Phở Hà Nội",
  "category": "restaurant",
  "address": "123 Nguyễn Huệ, Q1, TP.HCM",
  "latitude": 10.7769,
  "longitude": 106.7009,
  "rating": 4.5,
  "image_url": "https://example.com/pho.jpg"
}
```

---

### 2. 🎉 **Events Module** - Sự kiện
**Base Path:** `/api/v1/events`

| Method | Endpoint | Description | Request Body | Response |
|--------|----------|-------------|--------------|----------|
| `GET` | `/` | Danh sách sự kiện | Query: `?upcoming=1&past=0` | List of events |
| `POST` | `/` | Tạo sự kiện mới | Event data | Created event |
| `GET` | `/{id}` | Chi tiết sự kiện | - | Event details |
| `PUT` | `/{id}` | Cập nhật sự kiện | Update data | Updated event |
| `DELETE` | `/{id}` | Xóa sự kiện (soft delete) | - | 204 No Content |

**Filters:**
- `upcoming`: `1` (sự kiện sắp diễn ra)
- `past`: `1` (sự kiện đã qua)

**Sample Request Body:**
```json
{
  "title": "Lễ hội Tết Nguyên Đán 2025",
  "description": "Lễ hội truyền thống Việt Nam",
  "location": "Phố cổ Hội An",
  "latitude": 15.8801,
  "longitude": 108.3383,
  "start_time": "2025-01-25T08:00:00Z",
  "end_time": "2025-01-25T22:00:00Z"
}
```

---

### 3. 🍳 **Recipes Module** - Công thức nấu ăn
**Base Path:** `/api/v1/recipes`

| Method | Endpoint | Description | Request Body | Response |
|--------|----------|-------------|--------------|----------|
| `GET` | `/` | Danh sách công thức | Query: `?max_calories=500` | List of recipes |
| `POST` | `/` | Tạo công thức mới | Recipe data | Created recipe |
| `GET` | `/{id}` | Chi tiết công thức | - | Recipe details |
| `PUT` | `/{id}` | Cập nhật công thức | Update data | Updated recipe |
| `DELETE` | `/{id}` | Xóa công thức (soft delete) | - | 204 No Content |

**Filters:**
- `max_calories`: Số calories tối đa

**Sample Request Body:**
```json
{
  "title": "Phở Bò",
  "description": "Món phở truyền thống Việt Nam",
  "calories": 450,
  "image_url": "https://example.com/pho-bo.jpg"
}
```

---

### 4. 🚌 **Transport Module** - Giao thông công cộng
**Base Path:** `/api/v1/transport`

| Method | Endpoint | Description | Request Body | Response |
|--------|----------|-------------|--------------|----------|
| `GET` | `/` | Danh sách tuyến xe | Query: `?transport_type=bus&latitude=10.7769&longitude=106.7009&radius=5` | List of routes |
| `POST` | `/` | Tạo tuyến xe mới | Transport data | Created route |
| `GET` | `/{id}` | Chi tiết tuyến xe | - | Route details |
| `PUT` | `/{id}` | Cập nhật tuyến xe | Update data | Updated route |
| `DELETE` | `/{id}` | Xóa tuyến xe (soft delete) | - | 204 No Content |

**Filters:**
- `transport_type`: `bus`, `metro`, `train`, `tram`
- `latitude`, `longitude`, `radius`: Tìm kiếm theo tọa độ

**Sample Request Body:**
```json
{
  "route_name": "Xe buýt 01",
  "transport_type": "bus",
  "start_station": "Bến xe Miền Tây",
  "end_station": "Bến xe Chợ Lớn",
  "latitude": 10.7769,
  "longitude": 106.7009,
  "operating_hours": {
    "weekdays": "05:00-23:00",
    "weekends": "06:00-22:00"
  },
  "frequency": "10 min"
}
```

---

### 5. 🎓 **Education Module** - Quiz & Học tập
**Base Path:** `/api/v1/quizzes`

| Method | Endpoint | Description | Request Body | Response |
|--------|----------|-------------|--------------|----------|
| `GET` | `/` | Danh sách quiz | Query: `?difficulty_level=easy&active=1` | List of quizzes |
| `POST` | `/` | Tạo quiz mới | Quiz data | Created quiz |
| `GET` | `/{id}` | Chi tiết quiz | - | Quiz details |
| `PUT` | `/{id}` | Cập nhật quiz | Update data | Updated quiz |
| `DELETE` | `/{id}` | Xóa quiz (soft delete) | - | 204 No Content |

**Filters:**
- `difficulty_level`: `easy`, `medium`, `hard`
- `active`: `1` (chỉ quiz đang hoạt động)

**Sample Request Body:**
```json
{
  "title": "Quiz Văn hóa Việt Nam",
  "description": "Kiểm tra kiến thức về văn hóa truyền thống",
  "difficulty_level": "medium",
  "time_limit": 30,
  "is_active": true
}
```

---

### 6. 💰 **Finance Module** - Tài chính & Giá cả
**Base Path:** `/api/v1/finance`

| Method | Endpoint | Description | Request Body | Response |
|--------|----------|-------------|--------------|----------|
| `GET` | `/` | Danh sách tài chính | Query: `?type=gold&recent=1&hours=24` | List of finance records |
| `POST` | `/` | Tạo bản ghi mới | Finance data | Created record |
| `GET` | `/{id}` | Chi tiết bản ghi | - | Record details |
| `PUT` | `/{id}` | Cập nhật bản ghi | Update data | Updated record |
| `DELETE` | `/{id}` | Xóa bản ghi (soft delete) | - | 204 No Content |
| `GET` | `/gold/prices` | Giá vàng | - | Gold prices |
| `GET` | `/currency/rates` | Tỷ giá ngoại tệ | - | Currency rates |
| `GET` | `/fuel/prices` | Giá xăng dầu | - | Fuel prices |

**Filters:**
- `type`: `gold`, `currency`, `fuel`
- `recent`: `1` (chỉ bản ghi gần đây)
- `hours`: Số giờ để filter (mặc định 24)

**Sample Request Body:**
```json
{
  "type": "gold",
  "name": "SJC Gold",
  "current_price": 7500.00,
  "previous_price": 7400.00,
  "change_percentage": 1.35,
  "last_updated": "2025-01-02T10:00:00Z"
}
```

---

## 🔧 **Response Format**

### Success Response
```json
{
  "data": {
    "id": 1,
    "name": "Example",
    "created_at": "2025-01-02T10:00:00.000000Z",
    "updated_at": "2025-01-02T10:00:00.000000Z"
  }
}
```

### List Response
```json
{
  "data": [
    {
      "id": 1,
      "name": "Item 1"
    },
    {
      "id": 2,
      "name": "Item 2"
    }
  ]
}
```

### Error Response
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "name": ["The name field is required."]
  }
}
```

---

## 📊 **Database Schema**

### Tables
1. **users** - Người dùng
2. **travels** - Địa điểm du lịch
3. **events** - Sự kiện
4. **recipes** - Công thức nấu ăn
5. **ingredients** - Nguyên liệu
6. **routes** - Tuyến xe (transport)
7. **quizzes** - Quiz
8. **questions** - Câu hỏi
9. **question_options** - Lựa chọn câu trả lời
10. **quiz_attempts** - Lần thử quiz
11. **finance_records** - Bản ghi tài chính

---

## 🧪 **Testing**

### Chạy tất cả tests
```bash
php artisan test
```

### Chạy test cho module cụ thể
```bash
php artisan test tests/Feature/Api/V1/TravelTest.php
php artisan test tests/Feature/Api/V1/EventTest.php
php artisan test tests/Feature/Api/V1/RecipeTest.php
php artisan test tests/Feature/Api/V1/TransportTest.php
php artisan test tests/Feature/Api/V1/QuizTest.php
php artisan test tests/Feature/Api/V1/FinanceTest.php
```

---

## 🚀 **Quick Start**

### 1. Chạy server
```bash
php artisan serve
```

### 2. Test API
```bash
# Test Travel API
curl http://127.0.0.1:8000/api/v1/travel

# Test Events API
curl http://127.0.0.1:8000/api/v1/events

# Test Recipes API
curl http://127.0.0.1:8000/api/v1/recipes

# Test Transport API
curl http://127.0.0.1:8000/api/v1/transport

# Test Quiz API
curl http://127.0.0.1:8000/api/v1/quizzes

# Test Finance API
curl http://127.0.0.1:8000/api/v1/finance
```

---

## 📈 **Statistics**

- **Total Endpoints:** 33
- **Total Test Cases:** 62
- **Total Assertions:** 369
- **Test Coverage:** 100%
- **Architecture:** Clean Architecture (Controller → Service → Repository)
- **Database:** 11 tables với relationships
- **Validation:** Form Requests với custom messages
- **API Response:** JsonResource consistency
- **Soft Deletes:** Tất cả modules đều hỗ trợ

---

## 🎯 **Features**

✅ **RESTful API** với versioning  
✅ **Clean Architecture** - Separation of concerns  
✅ **Comprehensive Validation** - Form Requests  
✅ **Consistent Response** - JsonResource  
✅ **Soft Deletes** - Logical deletion  
✅ **Filtering & Search** - Query parameters  
✅ **Relationship Support** - Eloquent relationships  
✅ **Factory & Seeder** - Test data generation  
✅ **Comprehensive Testing** - Feature tests  
✅ **No Hard-coding** - Enums & configs  

---

## 🔮 **Future Enhancements**

- [ ] Authentication & Authorization (JWT/Sanctum)
- [ ] Rate Limiting
- [ ] API Caching
- [ ] Real-time Updates (WebSockets)
- [ ] File Upload Support
- [ ] API Analytics & Monitoring
- [ ] Swagger/OpenAPI Documentation
- [ ] Multi-language Support
- [ ] Advanced Search & Filtering
- [ ] Bulk Operations

---

## 📞 **Support**

**Vietnam Lifestyle SuperAPI** - Được phát triển với ❤️ cho cộng đồng Việt Nam!

---

*Last Updated: January 2, 2025*
*Version: 1.0.0*
