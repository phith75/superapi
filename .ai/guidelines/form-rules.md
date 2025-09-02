# 📝 AI Coding Guidelines – Filament 4 (Forms, Tables, Naming)

## 1. Quy tắc tổng quát

* ❌ Không hard-code string (label, option, path).
* ✅ Luôn dùng `enum`, `config()`, hoặc `trans()`.
* ❌ Không viết query logic trực tiếp trong field.
* ✅ Form chỉ định nghĩa schema, business logic đặt trong Service/Model.
* Method chain viết cùng dòng, nhất quán: `->required()->maxLength(255)`.
* Naming:

  * DB field → `snake_case`
  * PHP variable → `camelCase`
  * Không viết tắt lung tung (`dob` → phải là `date_of_birth`).

---

## 2. Form Rules

### TextInput

```php
TextInput::make('name')
    ->label(__('user.name'))
    ->required()
    ->maxLength(255);
```

### Select

```php
Select::make('status')
    ->label(__('user.status'))
    ->options(UserStatus::toArray())
    ->required();
```

### Relationship

```php
Select::make('role_id')
    ->relationship('role', 'name')
    ->required();
```

### File Upload

```php
FileUpload::make('avatar')
    ->label(__('user.avatar'))
    ->image()
    ->directory(config('paths.user_avatars'));
```

### Grouping Schema

```php
Section::make(__('user.account'))
    ->schema([
        TextInput::make('name'),
        TextInput::make('email'),
    ])->columns(2);
```

---

## 3. Table Rules

### Basic Table

```php
Tables\Table::make()
    ->columns([
        Tables\Columns\TextColumn::make('name')
            ->label(__('user.name'))
            ->sortable()
            ->searchable(),

        Tables\Columns\BadgeColumn::make('status')
            ->label(__('user.status'))
            ->enum(UserStatus::toArray())
            ->colors([
                'active' => 'success',
                'inactive' => 'danger',
            ]),
    ])
    ->filters([
        Tables\Filters\SelectFilter::make('status')
            ->options(UserStatus::toArray()),
    ]);
```

### Actions

```php
Tables\Actions\EditAction::make()
    ->label(__('actions.edit'))
    ->icon('heroicon-o-pencil')
    ->requiresConfirmation(),

Tables\Actions\DeleteAction::make()
    ->label(__('actions.delete'))
    ->icon('heroicon-o-trash')
    ->requiresConfirmation(),
```

---

## 4. Validation

* Validation rules phải inline trong Form/Table schema, không đặt ở Controller.
* Luôn dùng lang cho message (`lang/validation.php`).
* Ví dụ:

```php
TextInput::make('email')
    ->email()
    ->required()
    ->unique(ignoreRecord: true);
```

---

## 5. AI Guideline File (YAML style cho Boost)

```yaml
rules:
  - name: "Form Fields"
    description: >
      Never hard-code values. Always use enum/config/lang.
      Use relationship() for foreign keys.
      Group fields with Section/Grid.

  - name: "Table Columns"
    description: >
      Columns must be sortable and searchable when possible.
      Enums should use BadgeColumn with colors.

  - name: "Naming Convention"
    description: >
      snake_case for DB, camelCase for PHP variables, no abbreviations.

  - name: "Validation"
    description: >
      Declare validation inline in schema, not Controller.
      Always use lang for error messages.
```
