<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'category',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Boot the model to handle slug creation.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            } else {
                $blog->slug = Str::slug($blog->slug);
            }

            // Ensure slug is unique
            $originalSlug = $blog->slug;
            $count = 1;
            while (static::where('slug', $blog->slug)->where('id', '!=', $blog->id)->exists()) {
                $blog->slug = $originalSlug . '-' . $count++;
            }
        });
    }

    /**
     * Get the blog's featured image URL.
     */
    public function getImageUrlAttribute()
    {
        if (empty($this->image)) {
            return null;
        }

        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }

    /**
     * Scope a query to only include published blogs.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Get the root comments associated with this blog post.
     */
    public function comments()
    {
        return $this->hasMany(BlogComment::class)->whereNull('parent_id')->where('is_approved', true);
    }
}
