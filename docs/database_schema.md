# 🗄️ Database Schema – Vietnam Lifestyle SuperAPI

## 1. Travel & Local Module

**Table: travels**

```sql
id            BIGINT PK
name          VARCHAR(255)
category      ENUM('restaurant','cafe','museum','park','other')
address       VARCHAR(255)
latitude      DECIMAL(10,8)
longitude     DECIMAL(11,8)
image_url     VARCHAR(255)
rating        DECIMAL(2,1) DEFAULT 0
created_at    TIMESTAMP
updated_at    TIMESTAMP
```

**Table: reviews**

```sql
id            BIGINT PK
travel_id     BIGINT FK → travels.id
user_id       BIGINT FK → users.id
content       TEXT
rating        INT (1–5)
created_at    TIMESTAMP
```

---

## 2. Events Module

**Table: events**

```sql
id            BIGINT PK
title         VARCHAR(255)
description   TEXT
location      VARCHAR(255)
latitude      DECIMAL(10,8)
longitude     DECIMAL(11,8)
start_time    DATETIME
end_time      DATETIME
created_at    TIMESTAMP
updated_at    TIMESTAMP
```

**Table: event\_registrations**

```sql
id            BIGINT PK
event_id      BIGINT FK → events.id
user_id       BIGINT FK → users.id
status        ENUM('going','interested','cancelled')
created_at    TIMESTAMP
```

---

## 3. Recipes & Food Module

**Table: recipes**

```sql
id            BIGINT PK
title         VARCHAR(255)
description   TEXT
calories      INT
image_url     VARCHAR(255)
created_at    TIMESTAMP
updated_at    TIMESTAMP
```

**Table: ingredients**

```sql
id            BIGINT PK
recipe_id     BIGINT FK → recipes.id
name          VARCHAR(255)
quantity      VARCHAR(100)
```

---

## 4. Public Transport Module

**Table: routes**

```sql
id            BIGINT PK
name          VARCHAR(255)
type          ENUM('bus','metro')
created_at    TIMESTAMP
updated_at    TIMESTAMP
```

**Table: stations**

```sql
id            BIGINT PK
route_id      BIGINT FK → routes.id
name          VARCHAR(255)
latitude      DECIMAL(10,8)
longitude     DECIMAL(11,8)
order         INT
```

**Table: schedules**

```sql
id            BIGINT PK
route_id      BIGINT FK → routes.id
station_id    BIGINT FK → stations.id
arrival_time  TIME
departure_time TIME
```

---

## 5. Education Module

**Table: quizzes**

```sql
id            BIGINT PK
title         VARCHAR(255)
description   TEXT
created_at    TIMESTAMP
updated_at    TIMESTAMP
```

**Table: questions**

```sql
id            BIGINT PK
quiz_id       BIGINT FK → quizzes.id
question_text TEXT
type          ENUM('mcq','true_false','fill_blank')
```

**Table: answers**

```sql
id            BIGINT PK
question_id   BIGINT FK → questions.id
answer_text   VARCHAR(255)
is_correct    BOOLEAN
```

**Table: quiz\_attempts**

```sql
id            BIGINT PK
quiz_id       BIGINT FK → quizzes.id
user_id       BIGINT FK → users.id
score         INT
attempted_at  TIMESTAMP
```

---

## 6. Finance Module

**Table: finance\_records**

```sql
id            BIGINT PK
type          ENUM('gold','currency','fuel')
name          VARCHAR(100)
value         DECIMAL(12,2)
unit          VARCHAR(50)
recorded_at   TIMESTAMP
created_at    TIMESTAMP
```

---

## 7. Users (Common)

**Table: users**

```sql
id            BIGINT PK
name          VARCHAR(255)
email         VARCHAR(255) UNIQUE
password      VARCHAR(255)
role          ENUM('admin','developer','user') DEFAULT 'user'
api_key       VARCHAR(64) UNIQUE
created_at    TIMESTAMP
updated_at    TIMESTAMP
```

---

## 8. Migration mẫu (Laravel)

Ví dụ migration cho `travels`:

```php
Schema::create('travels', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->enum('category', ['restaurant','cafe','museum','park','other']);
    $table->string('address');
    $table->decimal('latitude', 10, 8);
    $table->decimal('longitude', 11, 8);
    $table->string('image_url')->nullable();
    $table->decimal('rating', 2, 1)->default(0);
    $table->timestamps();
});
```
