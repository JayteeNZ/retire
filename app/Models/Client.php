<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'surname',
        'email',
        'phone',
        'landline',
        'date_of_birth',
        'preferred_name',
        'status'
    ];

    /**
     * The attributes to be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_of_birth'
    ];

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->first_name} {$this->surname}"
        );
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
