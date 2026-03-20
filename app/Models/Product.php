<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category',
        'ingredients',
        'is_organic',
        'image'
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the image URL attribute (Primary image)
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->relationLoaded('images')) {
            $primaryImage = $this->images->where('is_primary', true)->first() ?? $this->images->first();
        } else {
            $primaryImage = $this->images()->where('is_primary', true)->first() ?? $this->images()->first();
        }

        if ($primaryImage) {
            return asset('storage/' . $primaryImage->image_path);
        }

        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return asset('images/no-product-image.png');
    }

    public function hasImage(): bool
    {
        if ($this->relationLoaded('images')) {
            if ($this->images->count() > 0) return true;
        } elseif ($this->images()->exists()) {
            return true;
        }

        return !empty($this->image) && Storage::disk('public')->exists($this->image);
    }
}
