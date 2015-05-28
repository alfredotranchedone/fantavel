<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [];

    protected $table = 'results';



}
