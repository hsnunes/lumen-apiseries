<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    public $timestamps = false;
    protected $fillable = ['nome'];
    // protected $perPage = 5;
    protected $appends = ['links'];

    public function episodio()
    {
                    // tem muitos
        return $this->hasMany(Episodio::class);
    }

    // Accessor para os links
    public function getLinksAttribute()
    {
        return [
            "self" => "/api/series/".$this->id,
            "episodios" => "/api/series/".$this->id."/episodios"
        ];
    }
}