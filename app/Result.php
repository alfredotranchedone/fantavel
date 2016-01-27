<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Result extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [];

    protected $table = 'results';

    public function scopeAverageResult($query, $teamId){
        return $query
            ->select(DB::raw('round(avg(result),2) as media'))
            ->where('teams_id',$teamId);
    }


}
