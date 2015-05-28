<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Team extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = ['id'];

    protected $table = 'teams';

    public function players()
    {
        return $this->hasMany('App\Player','teams_id','id');
    }

    public function modulo()
    {
        return $this->hasOne('App\Moduli','id','modulo_id');
    }

    public function scopeUserTeam($query, $userId){
        return $query
            ->select(['name'])
            ->where('user_id',$userId);
    }

}
