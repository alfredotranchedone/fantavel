<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model {

    protected $table = 'formations';

    protected $fillable = ['teams_id','players_codice','numero_maglia'];

    public function player()
    {
        return $this->hasOne('App\Player','codice','players_codice');
    }

    public function scopeTitolari($query,$giornataId,$teamId = null)
    {
        $return = $query
            ->leftJoin('punteggi','punteggi.players_codice','=','formations.players_codice')
            ->leftJoin('players','players.codice','=','formations.players_codice')
            ->where('formations.numero_maglia','!=',0)
            ->where('punteggi.giornata',$giornataId)
            ;

        if($teamId){
            $query->where('formations.teams_id','=',$teamId);
        } else {
            $query->where('formations.teams_id','!=',0);
        }

        return $return;

    }

}
