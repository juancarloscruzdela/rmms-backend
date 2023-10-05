<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Device extends Model
{
    use HasFactory;

    /**
     * Override fillable property data.
     *
     * @var array
     */
    protected $fillable = [
        'ip',
        'name',
        'archived'
    ];

    /**
     * User
     *
     * Get User Uploaded By Book
     *
     * @return object
     */
    public function user(): object
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'email');
    }
    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
