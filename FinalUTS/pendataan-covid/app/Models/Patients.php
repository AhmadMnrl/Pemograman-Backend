<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'address', 'status_id'];

    protected $primaryKey = 'id';
    // Definisi relasi Many-to-One dengan model StatusPatient
    public function status()
    {
        return $this->belongsTo(StatusPatients::class, 'status_id');
    }
}
