<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stagione extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = ['id'];

    protected $table = 'stagioni';

}
