<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    public static function sections()
    {
        $getsections = Section::with('categories')->where('status', 1)->get()->toArray();
        return $getsections;
    }

    public function categories()
    {
        return $this->hasMany('App\Models\Category', 'section_id')->where(['parent_id' => 0, 'status' => 1])->with('subcategories');
    }
}
