<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeRol extends Model
{
    use HasFactory;

    /**
     *
     * @var string
     */
    protected $table = 'empleado_rol';

    public $timestamps = false;
}
