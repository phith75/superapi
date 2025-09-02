# 📊 AI Coding Guidelines – Filament 4 Tables

## 1. Quy tắc tổng quát

* ❌ Không hard-code string (label, enum value).
* ✅ Luôn dùng `enum`, `config()`, hoặc `trans()`.
* Tất cả column cần có **label rõ ràng**, đa ngôn ngữ.
* Khi có thể → thêm `searchable()` và `sortable()`.
* Dùng `BadgeColumn` cho enum/status với màu sắc nhất quán.
* Filter phải bám theo enum/config, không hard-code.

---

## 2. Column Rules

### TextColumn

```php
Tables\Columns\TextColumn::make('name')
    ->label(__('user.name'))
    ->sortable()
    ->searchable();
```

### BadgeColumn (Enum)

```php
Tables\Columns\BadgeColumn::make('status')
    ->label(__('user.status'))
    ->enum(UserStatus::toArray())
    ->colors([
        'active' => 'success',
        'inactive' => 'danger',
    ]);
```

### DateTimeColumn

```php
Tables\Columns\TextColumn::make('created_at')
    ->label(__('common.created_at'))
    ->dateTime('d/m/Y H:i')
    ->sortable();
```

### Relationship Column

```php
Tables\Columns\TextColumn::make('role.name')
    ->label(__('user.role'))
    ->sortable();
```

---

## 3. Filters

### SelectFilter

```php
Tables\Filters\SelectFilter::make('status')
    ->options(UserStatus::toArray());
```

### TernaryFilter

```php
Tables\Filters\TernaryFilter::make('verified')
    ->label(__('user.verified'))
    ->trueLabel(__('common.yes'))
    ->falseLabel(__('common.no'));
```

### DateRangeFilter

```php
Tables\Filters\Filter::make('created_at')
    ->form([
        Forms\Components\DatePicker::make('from')->label(__('common.from')),
        Forms\Components\DatePicker::make('until')->label(__('common.until')),
    ])
    ->query(function (Builder $query, array $data) {
        return $query
            ->when($data['from'], fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
            ->when($data['until'], fn ($q, $date) => $q->whereDate('created_at', '<=', $date));
    });
```

---

## 4. Actions

### Row Actions

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

### Bulk Actions

```php
Tables\Actions\BulkAction::make('export')
    ->label(__('actions.export'))
    ->icon('heroicon-o-download')
    ->action(fn (Collection $records) => ...);
```

---

## 5. AI Guideline File (YAML style cho Boost)

```yaml
rules:
  - name: "Table Columns"
    description: >
      - Always use trans()/enum/config for labels and options.
      - Columns must be sortable and searchable when possible.
      - Use BadgeColumn for enums with consistent colors.

  - name: "Table Filters"
    description: >
      - Filters must use enums/config instead of hard-coded values.
      - Provide clear label translations for all filters.

  - name: "Table Actions"
    description: >
      - Row actions must use icons and require confirmation for destructive ops.
      - Bulk actions must provide clear labels and be safe by default.
```
