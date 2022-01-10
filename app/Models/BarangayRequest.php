<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function forms()
    {
        return $this->belongsTo(BarangayForm::class, 'barangay_form_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(BarangayFormAnswers::class, 'request_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
