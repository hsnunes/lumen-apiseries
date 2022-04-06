<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episodio extends Model
{
    public $timestamps = false;
    protected $fillable = ['temporada', 'numero', 'assistido', 'serie_id'];
    protected $appends = ['links'];

    public function serie()
    {
                    // pertence 
        return $this->belongsTo(Serie::class);
    }

    /** Accessors & Mutators */
    public function getAssistidoAttribute($assistido): bool
    {
        return $assistido;
    }

    /** Accessor para os links a serem passados */
    public function getLinksAttribute(): array
    {
        return [
            "self" => "/api/episodios/".$this->id,
            "serie" => "/api/series/".$this->serie_id
        ];
    }
}