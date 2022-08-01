<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     *
     * @var string
     */
    protected $table = 'empleado';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'email',
        'sexo',
        'area_id',
        'boletin',
        'descripcion'
    ];

    /**
     * Get the user that owns the phone.
     */
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function roles(){
        return $this->hasMany(EmployeeRol::class,'empleado_id', 'id');
    }
}
