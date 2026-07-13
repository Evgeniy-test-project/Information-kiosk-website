<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Orchid\Screen\AsSource;
use Orchid\Support\Facades\Toast;

class Document extends Model
{
    use AsSource;

    protected $fillable = [
        'category_id',
        'title',
        'sort_order',
        'is_active',
/*        'pdf_path',
        'page_count',
        'conversion_status',
        'conversion_error',*/
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'page_count' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function pages(): HasMany
    {
        return $this->hasMany(DocumentPage::class)->orderBy('page_number');
    }

    public function storageDirectory(): string
    {
        return 'documents/';
    }

    public function deleteFiles(): void
    {

    //   Storage::disk('public')->deleteDirectory($this->storageDirectory());
        Storage::disk('public')->delete($this->storageDirectory() .  $this->id . '.pdf');
        Toast::info('Документ удален.');
    }

/*    public function conversionStatusLabel(): string
    {
        return [
            self::STATUS_PENDING => 'Ожидает',
            self::STATUS_DONE => 'Готово',
            self::STATUS_FAILED => 'Ошибка',
        ][$this->conversion_status] ?? $this->conversion_status;
    }*/
}
