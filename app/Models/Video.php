<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Video extends Model
{
    use HasFactory;

    /**
     * Override fillable property data.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'category',
        'file',
        'views',
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

    // Add New Attribute to get file address
    protected $appends = ['file_url'];

    /**
     * Get Added File Attribute URL.
     *
     * @return string|null
     */
    public function getFileUrlAttribute(): string | null
    {
        if (is_null($this->file) || $this->file === "") {
            return null;
        }

        return url('') . "/files/videos/" . $this->file;
    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
