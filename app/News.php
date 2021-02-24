<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'title' => 'required',
        'body' => 'required',
    );
    
    // モデル間の関連づけ
    public function histories()
    {
        return $this->hasMany('App\History');
    }
}
