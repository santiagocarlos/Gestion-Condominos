<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Residential extends Model
{
    public static function get()
    {
    	$file = File::get(storage_path('app/file.txt'));
      $array_file = explode("\n", $file);

    	return $array_file;
    }

    public static function deleteConfig()
    {
    	$file = File::delete(storage_path('app/file.txt'));
    }
}
