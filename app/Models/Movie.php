<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'sinopse',
        'ano',
        'categoria',
        'category_id',
        'imagem_capa',
        'link_trailer',
        'user_id',
    ];

    protected $casts = [
        'ano' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function detail(): HasOne
    {
        return $this->hasOne(MovieDetail::class);
    }
}
