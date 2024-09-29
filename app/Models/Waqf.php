<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waqf extends Model
{
    protected $table = "awqaf";
    protected $fillable =['name', 'details'];
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }
}
