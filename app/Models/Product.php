<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Filesystem\FilesystemAdapter;

#[Fillable(['category_id', 'name', 'description', 'price', 'image_url'])]
#[Hidden(['created_at', 'updated_at'])]
class Product extends Model
{
    use HasFactory;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        /** @var FilesystemAdapter $disk */
        $disk = app('filesystem')->disk('public');

        return $disk->url($value);
    }
}