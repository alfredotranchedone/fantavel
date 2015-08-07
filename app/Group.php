<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

}
