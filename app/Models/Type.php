<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug']; 

    // Relazione inversa: Un tipo può avere molti progetti
    public function projects()
    {
        return $this->hasMany(Project::class); // Cambiato 'Projects' in 'Project'
    }
}

