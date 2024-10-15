<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{

    use HasFactory;

    protected $fillable = ['email','fname','lname'];

    public function websites(){
        return $this->belongsToMany(Website::class, 'subscriptions');
    }
}
