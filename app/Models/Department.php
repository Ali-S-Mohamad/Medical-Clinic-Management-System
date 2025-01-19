<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    /**
     * The relation between department and employees
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees(){
        return $this->hasMany(Employee::class);
    }

    /**
     * The relation between department and prescription
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prescriptions(){
        return $this->hasMany(Prescription::class);
    }

    /**
     * The relation between department and image
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function image()  {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * A scope to filter active departments
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', '1');
    }
}
