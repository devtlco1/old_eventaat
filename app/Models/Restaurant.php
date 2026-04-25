<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Restaurant extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;
//    use SoftDeletes, MultiTenantModelTrait, InteractsWithMedia, HasFactory;

    public $table = 'restaurents';

    protected $appends = [
        'logo',
        'images',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'mobile',
        'address',
        'website_url',
        'menu_url',
        'location_url',
        'city_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'team_id',
        'description1',
        'description2',
        'type',
        'type1',
        'numberolder',
        'numberChildren',
        'date',
        'paymentType',
        'privacies_id',
        'user_id',
        'kitchen_types_id',
        'features_id'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function restaurantEvents()
    {
        return $this->hasMany(Event::class, 'restaurant_id', 'id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'restaurant_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function restaurantStories()
    {
        return $this->hasMany(Story::class, 'restaurant_id', 'id');
    }

    public function stories()
    {
        return $this->hasMany(Story::class, 'restaurant_id', 'id');
    }

    public function restaurantOffers()
    {
        return $this->hasMany(Offer::class, 'restaurant_id', 'id');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'restaurant_id', 'id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'restaurant_id', 'id');
    }

    public function restaurantContacts()
    {
        return $this->hasMany(Contact::class, 'restaurant_id', 'id');
    }

    public function getLogoAttribute()
    {
        $file = $this->getMedia('logo')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getImagesAttribute()
    {
        $files = $this->getMedia('images');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview   = $item->getUrl('preview');
        });

        return $files;
    }

    public function getMenuImageAttribute()
    {
        $file = $this->getMedia('menu_image')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function user()
    {
        return $this->belongsTo(user::class, 'mobile', 'mobile');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
    public function chain()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
