<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function projectsCreated()
    {
        return $this->hasMany(Project::class, 'created_by');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'contractor_id');
    }

    public function awardedProjects()
    {
        return $this->hasMany(ProjectAward::class, 'awarded_to');
    }
    public function contractor()
    {
        return $this->hasOne(Contractor::class);
    }


    public function contractorCategories()
    {
        return $this->belongsToMany(Category::class, 'contractor_category', 'contractor_id', 'category_id')
            ->withTimestamps();
    }
}
