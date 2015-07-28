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

        return $query
            ->select(
                DB::raw('*,
                    ((vinte * 3) + (nulle * 1)) as punti,
                    (gf - gs) as differenzaReti
                    ')
            )
            ->where('giornata',$giornata)
            ->orderBy('punti','DESC')
            ->orderBy('vinte','DESC')
            ->orderBy('differenzaReti','DESC')
            ->orderBy('fp','DESC')
            ->get();

    }

}
