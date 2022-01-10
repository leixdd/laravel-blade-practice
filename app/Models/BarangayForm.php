<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayForm extends Model
{
    use HasFactory;

    public function questions()
    {
        return $this->hasMany(BarangayFormQuestion::class, 'barangay_form_id', 'id');
    }

}
