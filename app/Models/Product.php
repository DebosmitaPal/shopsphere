<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id', 'category_id', 'name', 'slug', 'description', 'price',
        'stock_quantity', 'image_path', 'status',
    ];

    protected function casts(): array
    {
        return ['price' => 'decimal:2'];
    }

    public function seller() { return $this->belongsTo(Seller::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function reviews() { return $this->hasMany(Review::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('status', 'active')->where('stock_quantity', '>', 0);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, fn ($q, $search) => $q->where('name', 'like', "%{$search}%"))
            ->when($filters['category'] ?? null, fn ($q, $category) => $q->whereHas('category', fn ($c) => $c->where('slug', $category)))
            ->when($filters['min_price'] ?? null, fn ($q, $price) => $q->where('price', '>=', $price))
            ->when($filters['max_price'] ?? null, fn ($q, $price) => $q->where('price', '<=', $price));
    }

    public function inventoryAlert(): bool
    {
        return $this->stock_quantity <= 5;
    }
}
