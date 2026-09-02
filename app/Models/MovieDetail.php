<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovieDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'diretor',
        'duracao_minutos',
        'classificacao',
        'observacoes',
    ];

    protected $casts = [
        'duracao_minutos' => 'integer',
    ];

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
