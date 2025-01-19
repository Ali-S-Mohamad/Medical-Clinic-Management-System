<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicInfo extends Model
{
    use HasFactory;
    protected $table = 'clinic_info';

    protected $fillable = [
        'name',
        'address',
        'email',
        'phone_number',
        'about',
        'established_at'];

        /**
         * The relation between clinic and  image
         * @return \Illuminate\Database\Eloquent\Relations\MorphOne
         */
        public function image()  {
            return $this->morphOne(Image::class, 'imageable');
        }
}
