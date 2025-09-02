# 📖 AI Coding Guidelines Index

Dự án **Vietnam Lifestyle SuperAPI** tuân theo các guideline sau để đảm bảo code đồng nhất, không hard-code và dễ mở rộng. Các guideline này được dùng trực tiếp bởi **Laravel Boost** để AI sinh code chuẩn hơn.

---

## 1. [Form Rules](./form_rules.md)

* Quy tắc viết Filament Forms.
* Tránh hard-code label/option.
* Validation inline trong schema.
* Group field bằng `Section` / `Grid`.

## 2. [Table Rules](./table_rules.md)

* Quy tắc viết Filament Tables.
* Columns luôn `sortable()` + `searchable()` nếu có thể.
* Dùng `BadgeColumn` cho enums, có màu nhất quán.
* Filter phải lấy từ enum/config.

## 3. [Naming Conventions](./naming.md)

* DB table: `snake_case` số nhiều.
* Model: PascalCase số ít.
* API endpoint: RESTful, resource số nhiều.
* Biến/hàm PHP: camelCase.
* Constant: UPPER\_CASE\_SNAKE.
* Translation key: dot notation (`user.name`, `quiz.attempt.success`).

---

👉 Khi dùng AI (Laravel Boost, Copilot, Claude…), luôn load **guidelines này** để đảm bảo consistency.

📌 Nếu có thay đổi guideline, cập nhật file tương ứng thay vì sửa trực tiếp code.
