<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Classifica extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['*'];

    protected $table = 'classifica';

    public function teams()
    {
        return $this->hasOne('App\Team','id','team_id');
    }

    public function scopeGetClassifica($query,$giornata=null)
    {

        // se giornata non è definita, recupera ultima giornata
        if(!$giornata)
            $giornata = Calendario::lastGiornata()->first()->giornata;

        if(is_null($giornata)){
            $giornata=0;
        }

        return $query
            ->select(
                DB::raw('classifica.*, teams.id, teams.name, teams.user_id,
                    ((vinte * 3) + (nulle * 1)) as punti,
                    (gf - gs) as differenzaReti
                    ')
            )
            ->leftJoin('teams','teams.id','=','classifica.team_id')
            ->where('giornata',$giornata)
            ->orderBy('punti','DESC')
            ->orderBy('vinte','DESC')
            ->orderBy('differenzaReti','DESC')
            ->orderBy('fp','DESC')
            ->get();

    }


    /**
     *
     * Recupera la posizione delle ultime 2 giornate (a partire dalla giornata indicata)
     * Se giornata=null recupera l'ultima giornata
     *
     * @param $query
     * @param $team
     * @param null $giornata
     * @return mixed
     */
    public function scopeAndamento($query,$team,$giornata=null)
    {

        // se giornata iniziale non è definita, recupera ultima giornata
        if(!$giornata)
            $giornata = Calendario::lastGiornata()->first()->giornata;

        $penultima = $giornata - 1;

        return $query
            ->select('posizione')
            ->where('team_id',$team)
            ->whereIn('giornata',[$giornata,$penultima])
            ->orderBy('giornata','DESC')
            ->get();

    }



    public function scopeGetGruppo($query,$giornata=false, $gruppo=false)
    {

        // se giornata iniziale non è definita, recupera ultima giornata
        if(!$giornata)
            $giornata = Calendario::lastGiornata()->first()->giornata;

        if(is_null($giornata))
            $giornata=0;

        $query
            ->select(
                DB::raw('
                teams.name,
                classifica.fp,
                (SELECT calendario.group_id
                    FROM calendario
                    WHERE calendario.giornata = '.$giornata.' LIMIT 1) AS gruppo')
            )
            ->leftJoin('teams','teams.id','=','team_id')
            ->where('classifica.giornata',$giornata);

        if($gruppo>0)
            $query->where('gruppo',$gruppo);

        return $query
            ->orderBy('classifica.fp','DESC')
            ->get();

    }



}
