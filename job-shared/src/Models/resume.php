<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class resume extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = "resumes";
    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = [
        'filename', 
        'fileUri', 
        'contactDetails', 
        'education', 
        'summary', 
        'skills', 
        'experience',
        'userID'
    ];

    protected $dates = ['deleted_at'];

    /**
     * تحديث الـ Casts عشان تتعامل مع مخرجات Gemini (Arrays)
     */
    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
            'contactDetails' => 'array', // عشان Gemini بيرجع JSON
            'education' => 'array',      // عشان الـ Foreach في الـ Blade
            'skills' => 'array',         // عشان تتعامل معاها كـ Tags
            'experience' => 'array',     // عشان هيكل الخبرات المعقد
        ];
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'userID', 'id');
    }
    
    /**
     * تعديل بسيط: العلاقة مع طلبات التوظيف 
     * المفروض الـ Foreign Key يكون resumeID مش userID
     */
    public function job_applications() 
    {
        return $this->hasMany(job_application::class, 'resumeID', 'id');
    }
}