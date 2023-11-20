<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPatients extends Model
{
    use HasFactory;
    protected $fillable = ['status', 'in_date_at', 'out_date_at'];

    protected $primaryKey = 'id';

    // Definisi relasi One-to-Many dengan model Patient
    public function patients()
    {
        return $this->hasMany(Patient::class, 'status_id');
    }
}
