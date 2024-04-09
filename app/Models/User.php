<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "User";
    protected $primaryKey = "uuid";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "uuid",
        "Gender",
        "Name",
        "Location",
        "age"
    ];
}
