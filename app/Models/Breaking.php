<?php

namespace App\Models;

use App\Helpers\LocalizationHelper;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Breaking extends Model
{
   use HasFactory;

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'breaking_news',
   ];

   /**
    * Get the route key for the model.
    */
   public function getRouteKeyName(): string
   {
       return 'breaking_news';
   }


   /**
    * @param $query
    */
   public function scopeCategory($query)
   {
      //  $query->where('taxonomy', 'category');
   }

   /**
    * @param $query
    */
   public function scopeSubcategory($query)
   {
      //  $query->where('taxonomy', 'category')->where('parent','>',0);
   }

   /**
    * @param $query
    */
   public function scopeTag($query)
   {
      //  $query->where('taxonomy', 'tag');
   }

   /**
    * @param $query
    * @return void
    */
   public function scopeCurrentLanguage($query)
   {
       $query->where('language_id', LocalizationHelper::getCurrentLocaleId());
   }

   /**
    * @param $query
    * @return void
    */
   public function scopeCurrentLangAuth($query)
   {
       $query->where('language_id', LocalizationHelper::getCurrentLocaleAuthdId());
   }

   /**
    * @param $query
    * @param $name
    */
   public function scopeOfName($query, $name)
   {
       $query->where('breaking_news', $name);
   }

   /**
    * @param $query
    * @param $name
    */
   public function scopeSearchName($query, $name)
   {
       $query->where("breaking_news", "LIKE", "%$name%");
   }
}
