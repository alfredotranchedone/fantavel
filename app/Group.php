<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];


    public function calendario()
    {
        return $this->hasMany('App\Calendario','group_id','id');
    }


}
