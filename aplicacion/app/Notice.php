<?php

namespace App;

use App\Category;
use App\DatesTranslator;
use App\Events\NoticeCreated;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use DatesTranslator;

		protected $fillable = [
        'title', 'description', 'category_id'
    ];

		protected $dispatchesEvents = [
			'created' => NoticeCreated::class
		];

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }
}
