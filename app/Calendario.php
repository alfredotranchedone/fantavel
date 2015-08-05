<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Calendario extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['giornata', 'team_1_id', 'team_2_id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'calendario';


    public function teams()
    {
        return $this->hasMany('App\Team','id','teams_id');
    }


    public function scopeNextMatches($query)
    {

        /* v.1
        return $query
            ->select(DB::raw('giornata,
                (SELECT name FROM teams WHERE teams.id = team_1_id) as team1,
                (SELECT name FROM teams WHERE teams.id = team_2_id) as team2,
                team_1_id, team_2_id'
                ))
            ->whereNull('result_team_1_id')
            ->whereNull('result_team_2_id')
            ->where('giornata',function($q) {
                $q->select('giornata')
                    ->from('calendario')
                    ->whereNull('result_team_1_id')
                    ->whereNull('result_team_2_id')
                    ->orderBy('giornata','ASC')
                    ->limit(1);
            });
        */

        /* v2
        SELECT min(DISTINCT(giornata)) AS giornata
        FROM calendario
        WHERE giornata NOT IN ( SELECT DISTINCT(giornata) FROM results )
        */
        return $query
            ->select(DB::raw('calendario.giornata,
                calendario.id,
                calendario.dataGiornata,
                calendario.dataConsegna,
                calendario.fattore_campo,
                t1.name as team1,
                t2.name as team2,
                (SELECT min(DISTINCT(giornata))
                FROM calendario
                WHERE giornata NOT IN ( SELECT DISTINCT(giornata) FROM results ))
                AS prossimaGiornata
            '))
            ->whereRaw('calendario.giornata = prossimaGiornata')
            ->leftJoin('teams as t1', 't1.id', '=', 'calendario.team_1_id')
            ->leftJoin('teams as t2', 't2.id', '=', 'calendario.team_2_id')
            ;



    }


    public function scopeLastMatches($query)
    {

        /* v.1
        SELECT giornata,team_1_id,team_2_id
            FROM calendario
            WHERE result_team_1_id NOTNULL
            AND giornata = (
              SELECT giornata
                  FROM calendario
                  WHERE result_team_1_id NOTNULL
                  ORDER BY giornata ASC
                  LIMIT 1
            );


        return $query
            ->select(DB::raw('giornata,
                (SELECT name FROM teams WHERE teams.id = team_1_id) as team1,
                (SELECT name FROM teams WHERE teams.id = team_2_id) as team2,
                team_1_id, team_2_id'
            ))
            ->whereNotNull('result_team_1_id')
            ->whereNotNull('result_team_2_id')
            ->where('giornata',function($q) {
                $q->select('giornata')
                    ->from('calendario')
                    ->whereNotNull('result_team_1_id')
                    ->whereNotNull('result_team_2_id')
                    ->orderBy('giornata','ASC')
                    ->limit(1);
            });
        */

        /* v.2.3
            SELECT calendario.*,
                t1.name as t1name,
                t2.name as t2name,
                (SELECT giornata
                    FROM results
                    GROUP BY giornata
                    ORDER BY giornata DESC
                    LIMIT 1) as lastGiornata
            FROM calendario
            LEFT JOIN teams t1 ON t1.id = calendario.team_1_id
            LEFT JOIN teams t2 ON t2.id = calendario.team_2_id
            WHERE calendario.giornata = lastGiornata
        */
        return $query
            ->select(DB::raw('calendario.giornata,
                calendario.id,
                calendario.fattore_campo,
                t1.name as team1,
                t2.name as team2,
                r1.result as resultTeam1,
                r2.result as resultTeam2,
                r1.goal as goalTeam1,
                r2.goal as goalTeam2,
                (SELECT max(DISTINCT(giornata))
                    FROM results
                    ) as lastGiornata
                    '
            ))
            ->whereRaw('calendario.giornata = lastGiornata')
            ->leftJoin('teams as t1', 't1.id', '=', 'calendario.team_1_id')
            ->leftJoin('teams as t2', 't2.id', '=', 'calendario.team_2_id')
            ->leftJoin('results as r1', function($join)
            {
                $join->on('r1.giornata', '=', 'lastGiornata')
                     ->on('r1.teams_id', '=', 'calendario.team_1_id');
            })
            ->leftJoin('results as r2', function($join)
            {
                $join->on('r2.giornata', '=', 'lastGiornata')
                     ->on('r2.teams_id', '=', 'calendario.team_2_id');
            })
            ;


    }



    public function scopeMatches($query,$giornata=0)
    {

        return $query
            ->select(DB::raw('calendario.giornata,
                calendario.fattore_campo,
                t1.id as idTeam1,
                t2.id as idTeam2,
                t1.name as team1,
                t2.name as team2,
                r1.result as resultTeam1,
                r2.result as resultTeam2,
                r1.goal as goalTeam1,
                r2.goal as goalTeam2'
            ))
            ->where('calendario.giornata', '=', $giornata)
            ->leftJoin('teams as t1', 't1.id', '=', 'calendario.team_1_id')
            ->leftJoin('teams as t2', 't2.id', '=', 'calendario.team_2_id')
            ->leftJoin('results as r1', function($join) use ($giornata)
            {
                $join->on('r1.giornata', '=', $giornata)
                     ->on('r1.teams_id', '=', 'calendario.team_1_id');
            })
            ->leftJoin('results as r2', function($join) use ($giornata)
            {
                $join->on('r2.giornata', '=', $giornata)
                     ->on('r2.teams_id', '=', 'calendario.team_2_id');
            })
            ;


    }



    public function scopeAllMatches($query)
    {

        /* v.1
        return $query
            ->select(DB::raw('giornata,
                (SELECT name FROM teams WHERE teams.id = team_1_id) as team1,
                (SELECT name FROM teams WHERE teams.id = team_2_id) as team2,
                team_1_id,
                team_2_id,
                result_team_1_id,
                result_team_2_id'
            ));
        */

        /* v.2
            SELECT calendario.giornata,
              t1.name as t1name,
              t2.name as t2name,
              r1.result as result1,
              r2.result as result2,
              r1.goal as goalTeam1,
              r2.goal as goalTeam2
            FROM calendario
              LEFT JOIN teams AS t1
                ON t1.id = calendario.team_1_id
              LEFT JOIN teams AS t2
                ON t2.id = calendario.team_2_id
              LEFT JOIN results AS r1
                ON r1.giornata = calendario.giornata
                   AND r1.teams_id = calendario.team_1_id
              LEFT JOIN results AS r2
                ON r2.giornata = calendario.giornata
                   AND r2.teams_id = calendario.team_2_id
        */

        return $query
            ->select(DB::raw('calendario.giornata,
              calendario.dataGiornata,
              calendario.dataConsegna,
              calendario.fattore_campo,
              calendario.id,
              t1.name as team1,
              t2.name as team2,
              r1.result as resultTeam1,
              r2.result as resultTeam2,
              r1.goal as goalTeam1,
              r2.goal as goalTeam2'
            ))
            ->leftJoin('teams as t1', 't1.id', '=', 'calendario.team_1_id')
            ->leftJoin('teams as t2', 't2.id', '=', 'calendario.team_2_id')
            ->leftJoin('results as r1', function($join)
            {
                $join->on('r1.giornata', '=', 'calendario.giornata')
                    ->on('r1.teams_id', '=', 'calendario.team_1_id');
            })
            ->leftJoin('results as r2', function($join)
            {
                $join->on('r2.giornata', '=', 'calendario.giornata')
                    ->on('r2.teams_id', '=', 'calendario.team_2_id');
            });


    }


    public function scopeNextGiornata($query)
    {

        return $query
            ->select(DB::raw('
                min(DISTINCT(giornata)) AS giornata
            '))
            ->whereRaw('calendario.giornata NOT IN ( SELECT DISTINCT(giornata) FROM results )');
            ;

    }

    public function scopeLastGiornata($query)
    {

        /*
        return $query
            ->select('giornata')
            ->distinct()
            ->whereNotNull('result_team_1_id')
            ->whereNotNull('result_team_2_id')
            ;
        */
        return $query
            ->select(DB::raw('
                max(DISTINCT(giornata)) AS giornata,
                dataGiornata
            '))
            ->whereRaw('calendario.giornata IN ( SELECT DISTINCT(giornata) FROM results )');
        ;

    }



    public function scopeResult($query,$giornata,$stagioneId=0)
    {

        return $query
            ->select(DB::raw('
                  calendario.id,
                  calendario.giornata,
                  calendario.team_1_id,
                  calendario.team_2_id,
                  calendario.fattore_campo,
                  (SELECT goal FROM results WHERE results.teams_id = team_1_id) as goal1,
                  (SELECT goal FROM results WHERE results.teams_id = team_2_id) as goal2,
                  (SELECT name FROM teams WHERE teams.id = team_1_id) as team1,
                  (SELECT name FROM teams WHERE teams.id = team_2_id) as team2,
                  (SELECT result FROM results
                    WHERE results.teams_id = team_1_id AND giornata = 1) as resultTeam1,
                  (SELECT result FROM results
                    WHERE results.teams_id = team_2_id AND giornata = 1) as resultTeam2
            '))
            ->where('giornata',$giornata)
            ->where('stagione_id',$stagioneId);

    }




}
