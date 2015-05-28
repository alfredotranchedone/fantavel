<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model {

    protected $guarded = ['id'];

    protected $fillable = ['nominativo', 'ruolo', 'codice','teams_id'];

    protected $table = 'players';

    public function teams()
    {
        return $this->hasOne('App\Team','id','teams_id');
    }

    public function formazione()
    {
        return $this->hasOne('App\Formation','players_codice','codice');
    }

}
