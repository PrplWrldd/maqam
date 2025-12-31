<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grave extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'ic_number', 'date_of_death', 'plot_number', 'gps_lat', 'gps_lng', 'photo'];
}
