<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Category extends Model
{
    use AsSource;
    use Filterable;
    protected $fillable = [
        'parent_id',
        'title',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->orderBy('sort_order')
            ->orderBy('title');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class)
            ->orderBy('sort_order')
            ->orderBy('title');
    }

    public function pathLabel(): string
    {
        $parts = [];
        $node = $this;

        while ($node) {
            array_unshift($parts, $node->title);
            $node = $node->relationLoaded('parent') ? $node->parent : $node->parent()->first();
        }

        return implode(' → ', $parts);
    }

    public function isDescendantOf(self $ancestor): bool
    {
        $node = $this;

        while ($node->parent_id !== null) {
            if ($node->parent_id === $ancestor->id) {
                return true;
            }

            $node = $node->parent ?? self::find($node->parent_id);

            if ($node === null) {
                break;
            }
        }

        return false;
    }

    public static function optionsForSelect(?int $excludeId = null): array
    {
        $options = ['' => '— Корневой раздел —'];
        $exclude = $excludeId !== null ? self::find($excludeId) : null;
        $categories = self::with('parent.parent.parent.parent.parent')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        foreach ($categories as $category) {
            if ($exclude !== null && $category->id === $exclude->id) {
                continue;
            }

            if ($exclude !== null && $category->isDescendantOf($exclude)) {
                continue;
            }

            $options[$category->id] = $category->pathLabel();
        }

        return $options;
    }
}
