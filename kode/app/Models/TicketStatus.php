<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class TicketStatus extends Model
{
    use HasFactory;


    protected $guarded = [];

    protected static function booted(){
        static::addGlobalScope('autoload', function (Builder $builder) {
            $builder->with(['translations' => function ($query) {
                return $query->where('locale', app()->getLocale());
            }]);
        });

        
    }



    public function scopeDefault($q){
        return $q->where('default',StatusEnum::true->status());
    }
    public function scopeActive($q){
        return $q->where('status',(StatusEnum::true)->status());
    }


    public function translations():MorphMany{

        return $this->morphMany(ModelTranslation::class, 'translateable');

    }

    public function getNameAttribute(mixed $value) :string{

        if(count($this->translations) !=0 ) {
            foreach ($this->translations as $translation) {
                if ($translation['key'] == 'name') {
                    return $translation['value'];
                }
            }
        }
        return $value;
    }


    public function tickets()
    {
        return $this->hasMany(SupportTicket::class, 'status','id');
    }



    /**
     * Get locale 
     *
     * @return array
     */
    public function getTranslateableLocaleAttribute() :array
    {
        $modelTranslations ['default'] = $this->getRawOriginal('name');
                       
        if( 0 < $this->translations->count()){
            foreach ($this->translations as $translation) {
                $modelTranslations[$translation->locale] =  $translation->value;
            }
        }

        return  $modelTranslations;
    }

}
