<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
		'title', 'excerpt', 'iframe', 'body', 'municipality_id', 'published_at', 'category_id','region_id', 'user_id'
	];

	protected $dates = [
        'dates'
    ];

    protected static function boot(){

        parent::boot();

        static::deleting(function($post){

            $post->tags()->detach();
            $post->photos->each->delete();

        });
    }

     public function getRouteKeyName(){
        return 'url';
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function photos(){
        return $this->hasMany(Photo::class);
    }


    public function owner(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function create(array $attributes = []){
        $attributes['user_id'] = auth()->id();
        $post = static::query()->create($attributes);
        $post->generateUrl();
        return $post;
    }

    public function generateUrl(){
            $url = str_slug($this->title);
           if ($this->whereUrl($url)->exists()) {
              $url = "{$url}-{$this->id}";
           }
           $this->url =  $url;
           $this->save();
    }

    public function scopePublished($query){
        return $query->with(['owner','category', 'tags', 'photos', 'municipality'])
                ->whereNotNull('published_at')
                ->where('published_at','<=', Carbon::now())
                ->latest('published_at');
    }

    public function scopeAllowed($query){
        if (auth()->user()->can('view', $this)) {
            return  $query;
        }
        return  $query->where('user_id', auth()->id());
    }

    public function setPublishedAtAttribute($published_at){
        $this->attributes['published_at'] = $published_at
                                ? Carbon::parse($published_at)
                                : null;
    }

    public function setCategoryIdAttribute($category_id){
        $this->attributes['category_id'] = Category::find($category_id)
                                ? $category_id
                                : Category::create(['name' => $category_id])->id;
    }

    public function syncTags($tags){
        $tagIds = collect($tags)->map(function($tag){
            return Tag::find($tag) ? $tag : Tag::create(['name' => $tag])->id;
        });
        return $this->tags()->sync($tagIds);
    }
}
