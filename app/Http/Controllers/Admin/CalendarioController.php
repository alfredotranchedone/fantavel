<?php

namespace App\Http\Controllers\Admin;

use App\Calendario;
use App\Classifica;
use App\Formation;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Moduli;
use App\Player;
use App\Punteggi;
use App\Result;
use App\Team;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CalendarioController extends Controller {

    private $giornata;
    private $stagione_id;
    // dichiara fattore campo
    private $fattore_campo = 2;

	public function getIndex()
	{

        return redirect('admin/calendario/riepilogo');

	}


    public function getMatch($calendarioId)
    {

        $match = Calendario::
                             select(DB::raw(
                                'calendario.*,
                                t1.name as team_1_nome,
                                t2.name as team_2_nome,
                                t1.user_id as team_1_user_id,
                                t2.user_id as team_2_user_id
                                '
                             ))
                             ->leftJoin('teams as t1', 't1.id', '=', 'calendario.team_1_id')
                             ->leftJoin('teams as t2', 't2.id', '=', 'calendario.team_2_id')
                             ->where('calendario.id',$calendarioId)->first();

        $team_1_result = Result::leftJoin('moduli', 'moduli.id', '=', 'results.modulo_id')
                            ->where('teams_id',$match->team_1_id)
                            ->where('giornata',$match->giornata)
                            ->first();
        $team_2_result = Result::leftJoin('moduli', 'moduli.id', '=', 'results.modulo_id')
                            ->where('teams_id',$match->team_2_id)
                            ->where('giornata',$match->giornata)
                            ->first();

        $team_1_players = Formation::
                            leftJoin('players','players.codice','=','formations.players_codice')
                            ->leftJoin('punteggi',function($join) use ($match){
                                $join
                                    ->on('punteggi.players_codice','=','formations.players_codice')
                                    ->on('punteggi.giornata','=',$match->giornata);
                            })
                            ->where('formations.teams_id',$match->team_1_id)
                            ->where('formations.giornata_id',$match->giornata)
                            ->where('formations.players_codice','!=',0)
                            ->get();

        $team_2_players = Formation::
                            leftJoin('players','players.codice','=','formations.players_codice')
                            ->leftJoin('punteggi',function($join) use ($match){
                                $join
                                    ->on('punteggi.players_codice','=','formations.players_codice')
                                    ->on('punteggi.giornata','=',$match->giornata);
                            })
                            ->where('formations.teams_id',$match->team_2_id)
                            ->where('formations.giornata_id',$match->giornata)
                            ->where('formations.players_codice','!=',0)
                            ->get();

        // dd($team_1_result,$team_2_result,$team_1_players);

        return view('pages.admin.calendario.dettaglio',[
            'match' => $match,
            'team_1_result' => $team_1_result,
            'team_2_result' => $team_2_result,
            'team_1_players' => $team_1_players,
            'team_2_players' => $team_2_players,
        ]);

    }




    public function postUploadRisultati(Request $request){

        if( $request->input('confirmText') == 'UPLOAD'):

            $destinationPath = 'uploads/risultati';
            $f = $request->file('xls');

            $this->giornata = $request->input('giornata');

            $this->stagione_id = $request->input('stagione_id',0); // opz

            if ($f->isValid()) :

                // $name = date('Y.m.d_') . $f->getClientOriginalName();
                $name = 'giornata_'. $this->giornata .'_'. date('Y-m-d') .'.xls';

                $f->move($destinationPath,$name);

                Excel::load('uploads/risultati/'.$name, function($reader) {

                    $reader->noHeading();

                    $reader->skip(2);

                    $results = $reader->get();

                    /*
                     * Schema .xls Gazzetta SENZA TREQUARTISTA:
                     *   0 => "Cod."
                     *   1 => "Giocatore"
                     *   2 => "Squadra"
                     *   3 => "Ruolo"
                     *   4 => "Stato"
                     *   5 => "Quotazione"
                     *   6 => "Magic Punti"
                     *   7 => "Voto Pagella"
                     *   8 => "Gol"
                     *   9 => "Ammonizione"
                     *   10 => "Espulsione"
                     *   11 => "Rigore Par/Sbag."
                     *   12 => "Autorete"
                     *   13 => "Assist"
                    */

                    /*
                     * Schema .xls Gazzetta CON TREQUARTISTA:
                     *   0 => "Cod."
                     *   1 => "Giocatore"
                     *   2 => "Squadra"
                     *   3 => "Ruolo"
                     *   4 => "Ruolo2"
                     *   5 => "Stato"
                     *   6 => "Quotazione"
                     *   7 => "Magic Punti"
                     *   8 => "Voto Pagella"
                     *   9 => "Gol"
                     *   10 => "Ammonizione"
                     *   11 => "Espulsione"
                     *   12 => "Rigore Par/Sbag."
                     *   13 => "Autorete"
                     *   14 => "Assist"
                    */


                    foreach($results as $row){

                        $voto = ($row[8] == '-') ? null : $row[8];
                        $magic_punti = ($row[7] == '-') ? null : $row[7];

                        Punteggi::create([
                            'giornata' => $this->giornata,
                            'stagione_id' => $this->stagione_id,
                            'players_codice' => intval($row[0]),
                            'voto' => $voto,
                            'quotazione' => $row[6],
                            'stato' => $row[5],
                            'magic_punti' => $magic_punti,
                            'gol' => $row[9],
                            'ammonizione' => $row[10],
                            'espulsione' => $row[11],
                            'rigori' => $row[12],
                            'autogol' => $row[13],
                            'assist' => $row[14],
                            ]);

                    }

                });


                // Salva i risultati
                $this->calcolaRisultati($this->giornata,$this->stagione_id);

                // Aggiorna Classifica
                $this->aggiornaClassifica($this->giornata,$this->stagione_id);

                return redirect('admin/calendario/risultato-giornata/'.$this->giornata)
                    ->with('message', 'Punteggi salvati!')
                    ->with('messageType','success');

            endif;

            $msg = 'File non valido.';
            $msgType = 'warning';

        else:
            $msg = 'Operazione non confermata';
            $msgType = 'warning';
        endif;

        return redirect('admin/calendario/riepilogo')
            ->with('message', $msg)
            ->with('messageType',$msgType);

    }


    public function getMostra()
	{

        $all = Calendario::allMatches()->get()->toArray();

        // raggruppa i risultati per giornata
        $groups = array();
        foreach ($all as $item) {
            $key = $item['giornata'];
            $fc = $item['fattore_campo'];
            $dG = $item['dataGiornata'];
            $dC = $item['dataConsegna'];
            if (!isset($groups[$key])) {
                $groups[$key] = [
                    'incontri'=>array($item),
                    'giornata'=>$key,
                    'dataGiornata'=> $dG,
                    'dataConsegna'=> $dC,
                    'fattore_campo' => $fc
                ];
            } else {
                $groups[$key]['incontri'][] = $item;
                $groups[$key]['giornata'] = $key;
                $groups[$key]['dataGiornata'] = $dG;
                $groups[$key]['dataConsegna'] = $dC;
                $groups[$key]['fattore_campo'] = $fc;

            }
        }

       // dd($groups);

        return view('pages.admin.calendario.mostra',[
            'all' => $groups
        ]);

	}



    public function getRiepilogo()
	{

        $next = Calendario::nextMatches()->get();
        $last = Calendario::lastMatches()->get();

        $nextGiornata = Calendario::nextGiornata()->first();
        $lastGiornata = Calendario::lastGiornata()->first();

        $nextData = 0;
        $nextLimite = 0;

        if(!$next->isEmpty()) {

            $nextData = $next->first()->dataGiornata;

            if(!$last->isEmpty())
                $nextLimite =  $next->first()->dataConsegna;

        } else {
            $nextData = false;
        }


        $dg = false;
        $dc = false;

        if($nextData > 0) {
            $d = new Carbon();
            $dg = $d->createFromTimestamp(strtotime($nextData))
                ->format('d/m/Y H:i:s');
        }

        if($nextLimite>0) {
            $c = new Carbon();
            $dc = $c->createFromTimestamp(strtotime($nextLimite))
                ->format('d/m/Y H:i:s');
        }

        return view('pages.admin.calendario.index',[
            'nextMatches' => $next,
            'lastMatches' => $last,
            'nextGiornata' => $nextGiornata,
            'lastGiornata' => $lastGiornata,
            'dataGiornata' => $dg,
            'dataConsegna' => $dc,
        ]);

	}


    public function getRisultatoGiornata($giornata)
	{


        $matches = Calendario::result($giornata)->get();

        return view('pages.admin.calendario.risultato_giornata',[
            'giornata' => $giornata,
            'matches' => $matches,
        ]);

	}



    public function getGenera(){

        $totaleTeam = Team::count();

        return view('pages.admin.calendario.genera',[
            'totaleTeam' => $totaleTeam
        ]);

    }


    public function postGenera(Request $request){

        $totaleTeam = Team::count();
        $gironi = $request->input('gironi');
        $teams = Team::all(['id','name'])->toArray();

        $matches = $this->algoritmoDiBerger($teams,$gironi,'echo');

        return view('pages.admin.calendario.preview',[
            'matches' => $matches,
            'gironi' => $gironi
        ]);

    }



    public function postSave(Request $request){


        if($request->input('confirm') === 'CONFIRM') {

            // svuota tabella calendario
            Calendario::truncate();

            // svuota classifica
            Classifica::truncate();

            $totaleTeam = Team::count();
            $gironi = $request->input('gironi');
            $teams = Team::all(['id', 'name']);

            $matches = $this->algoritmoDiBerger($teams->toArray(), $gironi, 'array');

            foreach ($matches as $m) {
                Calendario::create($m);
            }

            // inizializza classifica
            $teams->each(function($team){
                $classifica = new Classifica();
                $classifica->team_id = $team->id;
                $classifica->vinte = 0;
                $classifica->nulle = 0;
                $classifica->perse = 0;
                $classifica->gf = 0;
                $classifica->gs = 0;
                $classifica->giornata = 0;
                $classifica->stagione_id = 0;
                $classifica->fp = 0;
                $classifica->posizione = '0';
                $classifica->save();
            });

            $msg = 'Calendario Generato!';
            $msgType = 'success';

        } else {

            $msg = 'Calendario NON Generato';
            $msgType = 'warning';

        }

        return redirect('admin/calendario/riepilogo')
                ->with('message', $msg)
                ->with('messageType',$msgType);

    }




    /**
     * @param array $arrSquadre array delle squadre (array di array) :
     *                                  array(
     *                                      array(id,nome),
     *                                      array(id,nome),
     *                                      ...
     *                                  );
     * @param int   $gironi
     * @param string(echo|array)  $output  stampa a video il calendario o restituisci un array
     */
    private function algoritmoDiBerger($arrSquadre,$gironi = 1,$output = 'array')
    {

        $team_names = array_column($arrSquadre, 'name');
        $team_ids = array_column($arrSquadre, 'id');

        //dd($team_names, $team_ids, $arrSquadre);

        if($output == 'array'):
            // ids
            $arrSquadre = $team_ids;
        else:
            // nomi
            $arrSquadre = $team_names;
        endif;

        // prepara per l'output
        $outputEcho = '';
        $outputArray = [];

        $numero_squadre = count($arrSquadre);
        if ($numero_squadre % 2 == 1) {
                $arrSquadre[]="BYE";   // numero giocatori dispari? aggiungere un riposo (BYE)!
            $numero_squadre++;
        }
        $giornate = $numero_squadre - 1;
        /* crea gli array per le due liste in casa e fuori */
        for ($i = 0; $i < $numero_squadre /2; $i++)
        {
            $casa[$i] = $arrSquadre[$i];
            $trasferta[$i] = $arrSquadre[$numero_squadre - 1 - $i];


        }

        $outputEcho .= '<div class="row">';

        for ($i = 0; $i < $giornate*$gironi; $i++)
        {
            /* stampa le partite di questa giornata */
            $outputEcho .= '<div class="col-md-4 col-sm-6 col-xs-12">';
            $outputEcho .= '<p style="border-bottom: 1px dashed #eeeeee;"><b>'.($i+1).'a Giornata</b></p>';


            /* alterna le partite in casa e fuori */
            if (($i % 2) == 0)
            {
                for ($j = 0; $j < $numero_squadre /2 ; $j++)
                {

                    $outputEcho .= ' '.$trasferta[$j].' - '.$casa[$j].'<BR>';
                    $outputArray[] = [
                        'giornata' => $i+1,
                        'team_1_id' => $casa[$j],
                        'team_2_id' => $trasferta[$j]
                    ];
                }
            }
            else
            {
                for ($j = 0; $j < $numero_squadre /2 ; $j++)
                {
                    $outputEcho .= ' '.$casa[$j].' - '.$trasferta[$j].'<BR>';
                    $outputArray[] = [
                        'giornata' => $i+1,
                        'team_1_id' => $trasferta[$j],
                        'team_2_id' => $casa[$j]
                    ];
                }

            }

            // Ruota in gli elementi delle liste, tenendo fisso il primo elemento
            // Salva l'elemento fisso
            $pivot = $casa[0];

            /* sposta in avanti gli elementi di "trasferta" inserendo
               all'inizio l'elemento casa[1] e salva l'elemento uscente in "riporto" */
            array_unshift($trasferta, $casa[1]);
            $riporto = array_pop($trasferta);


            /* sposta a sinistra gli elementi di "casa" inserendo all'ultimo
               posto l'elemento "riporto" */
            array_shift($casa);
            array_push($casa, $riporto);

            // ripristina l'elemento fisso
            $casa[0] = $pivot ;

            $outputEcho .= '<hr/></div>';

        }


        $outputEcho .= '</div>';

        switch ($output){
            case 'echo':
                return $outputEcho;
                break;
            case 'array':
            default:
                return $outputArray;
                break;
        }

    }


    /**
     * @param $giornata
     * @param int $stagioneId
     */
    private function calcolaRisultati($giornata,$stagioneId = 0){


        // estrai teams
        $teams = Team::all(['id']);

        // estrai moduli
        $moduli = Moduli::all(['name']);


        // per ogni team...
        $teams->each(function($t) use ($giornata){

            $team_id = $t->id;

            // ...controlla se esiste la formazione per la giornata corrente
            $current_formation = Formation::where('teams_id',$team_id)
                ->where('giornata_id',$giornata)
                ->get();

            // se non esiste formazione...
            if($current_formation->isEmpty()){

                // ...recupera la precedente formazione
                $last_formation = Formation::where('teams_id',$team_id)
                    ->where('giornata_id',function($q) use ($giornata, $team_id)
                    {
                        $q->select('giornata_id')
                            ->distinct()
                            ->from('formations')
                            ->where('numero_maglia','!=',0)
                            ->where('teams_id',$team_id)
                            ->orderBy('giornata_id','desc');
                    })
                    ->get();


                // duplica la formazione, ma aggiorna la giornata!
                $last_formation->each(function($l) use($giornata) {
                    $new = $l->replicate();
                    $new->giornata_id = $giornata;
                    $new->save();
                });

            }

        });

        // estrai i punteggi dei titolari della giornata in corso
        $titolari = Formation::titolari($giornata)->get();

        // controlla se è attivo il fattore campo per la giornata
        $fc = Calendario::where('giornata',$giornata)->get();
        if( ( ! $fc->isEmpty() ) AND ($fc->first()->fattore_campo==1) ){
            $check_fattore_campo = true;
        } else {
            $check_fattore_campo = false;
        }

        // raggruppa i titolari per squadra (teams_id) e numero maglia
        $titolariByTeam = [];
        foreach ($titolari as $key => $titolare) {
            $titolariByTeam[$titolare->teams_id][$titolare->numero_maglia] = [
                'maglia' => $titolare->numero_maglia,
                'codice' => $titolare->players_codice,
                'ruolo' => $titolare->ruolo,
                'punti' => $titolare->magic_punti,
            ];
        }

        //
        $counter_team = 0;

        // inizializza array per aggiornare risultati e moduli
        $totale_partita = [];

        // conteggia i totali
        foreach ($titolariByTeam as $team_id => $giocatore) :

            $moduloId = Team::find($team_id,['modulo_id'])->modulo_id;
            $moduloNome = Team::find($team_id)->modulo->name;
            // $moduloModificatore = Team::find($team_id)->modulo->modificatore;

            // converti modulo in array
            $arrayModuloNome = explode('-',$moduloNome);

            $totale_squadra = 0;
            $sostituzioni = 0;

            // Costruisci array riserve
            $arrayRiserve = [];
            for($k=12;$k<=24;$k++){

                if(array_key_exists($k,$giocatore) AND !is_null($giocatore[$k]['punti'])) {
                    $arrayRiserve[$k] = $giocatore[$k];
                }

            }

            // Array Giocatori da sostituire
            $arrayDaSostituire = [];


            //echo '<h3>Team '.$team_id.':</h3>';


            foreach ($giocatore as $numero_maglia => $m) :

                $mp = $m['punti'];
                $ruolo = $m['ruolo'];


                // gestisci sostituzione
                if($mp == 0 ) {

                    /*
                    echo "s$sostituzioni";
                    echo "NO ";
                    */

                    // popola array ruoli da sostituire
                    $arrayDaSostituire[] = $m['ruolo'];

                }


                $totale_squadra += $mp;

                // echo $numero_maglia .' | '. $m['ruolo'] .' -> '. $mp .'<br>';

                if($numero_maglia >= 11)
                    break;

            endforeach;


            // assegnazione iniziale modulo effettivo (che potrebbe variare con le sostituzioni
            $arrayModuloEffettivo = $arrayModuloNome;

            /*
            echo '<hr>PRE ';
            echo json_encode($arrayDaSostituire);
            echo '<br>';
            echo json_encode($arrayRiserve);
            */

            // echo '<hr> Tot: '.$totale_squadra;

            $k=1;
            foreach ($arrayDaSostituire as $sost) {

                if ($sostituzioni >= 3)
                    break;

                // cicla prima per vedere se ci sono riserve con lo stesso ruolo
                foreach ($arrayRiserve as $key => $r) {

                    // se ruolo riserva == ruolo giocatore da sostituire
                    if ($sost == $r['ruolo']) {

                        // rimuovi riserva
                        unset($arrayRiserve[$key]);

                        // conta sostituzione
                        $sostituzioni++;

                        // aggiungi punteggio della sostituzione
                        $totale_squadra += $r['punti'];

                        // esci dal ciclo
                        continue 2;
                    }

                }

                reset($arrayRiserve);

                // echo '<hr>INFRA '.$k.'.  ';
                // echo json_encode($arrayRiserve);

                // cicla per riserve con altro ruolo, avendo cura di modificare il modulo
                // e controllare se il modulo effettivo è in effetti "lecito"
                foreach ($arrayRiserve as $key => $r) {

                    // echo '<br>'. $r['ruolo'].'<br>';

                    // Non contare il Portiere, se ancora presente
                    if ($r['ruolo'] == 'P') {
                        continue;
                    }

                    // modulo temporaneo: diventa effettivo se la sostituzione va a buon fine
                    $arrayModuloTemp = $arrayModuloEffettivo;

                    // il modulo NON prevede trequartisti
                    if (count($arrayModuloTemp) == 3) {

                        // controlla il ruolo del giocatore da sostituire
                        switch ($sost) {
                            case 'D':
                                $arrayModuloTemp[0]--;
                                break;
                            case 'C':
                                $arrayModuloTemp[1]--;
                                break;
                            case 'A':
                                $arrayModuloTemp[2]--;
                                break;
                        }

                        // controlla il ruolo del sostituto
                        switch ($r['ruolo']) {
                            case 'D':
                                $arrayModuloTemp[0]++;
                                break;
                            case 'C':
                                $arrayModuloTemp[1]++;
                                break;
                            case 'A':
                                $arrayModuloTemp[2]++;
                                break;
                        }

                        // il modulo PREVEDE trequartisti
                    } elseif (count($arrayModuloTemp) == 4) {

                        // controlla il ruolo del giocatore da sostituire
                        switch ($sost) {
                            case 'D':
                                //echo '### CASE D <br>';
                                $arrayModuloTemp[0]--;
                                break;
                            case 'C':
                                $arrayModuloTemp[1]--;
                                //echo '### CASE C <br>';
                                break;
                            case 'T':
                                $arrayModuloTemp[2]--;
                                //echo '### CASE T <br>';
                                break;
                            case 'A':
                                $arrayModuloTemp[3]--;
                                //echo '### CASE A <br>';
                                break;
                        }

                        // controlla il ruolo del sostituto
                        switch ($r['ruolo']) {
                            case 'D':
                                $arrayModuloTemp[0]++;
                                break;
                            case 'C':
                                $arrayModuloTemp[1]++;
                                break;
                            case 'T':
                                $arrayModuloTemp[2]++;
                                break;
                            case 'A':
                                $arrayModuloTemp[3]++;
                                break;
                        }


                    }

                    //echo '*** '. implode('-',$arrayModuloTemp).' ***';

                    // controlla validità del modulo
                    if (in_array(implode('-', $arrayModuloTemp), array_flatten($moduli->toArray()))) {

                        // modulo ok: conserva la modifica
                        $arrayModuloEffettivo = $arrayModuloTemp;

                        // rimuovi riserva
                        unset($arrayRiserve[$key]);

                        // conta sostituzione
                        $sostituzioni++;

                        // aggiungi punteggio della sostituzione
                        $totale_squadra += $r['punti'];

                        // esci dal ciclo
                        break;

                    }

                }

                // echo '<br>Tot: '.$totale_squadra;
                $k++;
            }

            /*
            echo '<p><b>Totale: '.$totale_squadra.'</b> + '. $moduloModificatore .'<br>';
            echo 'Totale Sostituzioni: '.$sostituzioni.'<br>';
            echo 'Modulo: '. Team::find($team_id)->modulo->name.'<br>';
            echo 'Modulo Modificatore: '. $moduloModificatore .'</p>';
            echo 'Modulo Nome:'.$moduloNome .' EFF '. implode('-',$arrayModuloEffettivo);

            echo '<br>POST ';
            echo json_encode($arrayDaSostituire);
            echo json_encode($arrayRiserve);

            */





            // controlla se il fattore campo è abilitato. Se sì, aggiungi il mod
            if($check_fattore_campo) {

                foreach ($fc as $c) :
                    if($team_id == $c->team_1_id):
                        //$old_totale = $totale_squadra;
                        $totale_squadra = $totale_squadra + $this->fattore_campo;
                        //echo sprintf(' casa! %s %s | ', $totale_squadra + $moduloModificatore,$old_totale + $moduloModificatore);
                    endif;
                endforeach;

            }


            // echo sprintf('%s: %s (%s)<br>',$team_id,$totale_squadra,implode('-',$arrayModuloEffettivo));

            /**
             * TODO
             * - COMPLETARE PROCEDURA SOSTITUZIONE PORTIERE!!!
             * - CONTROLLARE MODULI
             */
            //dd($modulo_effettivo, array_count_values($modulo_effettivo));

            /* Calcolare dopo il ciclo, assieme al conteggio del modulo!!! */
            // $goal_fatti = $this->calcolaGoals( $totale_squadra + $moduloModificatore );



            /* Salva risultato */
            $risultato = new Result();
            $risultato->giornata    = $giornata;
            $risultato->teams_id    = $team_id;
            $risultato->stagione_id = $stagioneId;
            // $risultato->result      = $totale_squadra + $moduloModificatore;
            $risultato->modulo_id   = $moduloId;
            // $risultato->goal        = $goal_fatti;
            $risultato->save();

            $risultatoId = $risultato->id;

            $counter_team++;

            // recupera modificatore del modulo finale!
            $moduloModificatore = Moduli::whereName( implode('-', $arrayModuloEffettivo) )->first()->modificatore;

            $totale_partita[$team_id] = [
                'resultId' => $risultatoId,
                'modificatoreModulo' => $moduloModificatore,
                'totaleSquadra' => $totale_squadra
            ];

        endforeach;


        // Aggiorna i risultati con i totali completi di modificatore modulo
        //  (totale squadra - modificatore modulo avversario)
        $fc->each(function($partita) use ($totale_partita){

            // associa i dati dei team
            $team_1         = $totale_partita[$partita->team_1_id];
            $result_1_id    = $team_1['resultId'];
            $result_1_mod   = $team_1['modificatoreModulo'];
            $result_1_tot   = $team_1['totaleSquadra'];

            $team_2         = $totale_partita[$partita->team_2_id];
            $result_2_id    = $team_2['resultId'];
            $result_2_mod   = $team_2['modificatoreModulo'];
            $result_2_tot   = $team_2['totaleSquadra'];

            // calcola il totale compreso di modificatore dell'avversario
            $totale_finale_1 = $result_1_tot + $result_2_mod;
            $totale_finale_2 = $result_2_tot + $result_1_mod;

            // calcola i gol
            $goal_fatti_1 = $this->calcolaGoals( $totale_finale_1 );
            $goal_fatti_2 = $this->calcolaGoals( $totale_finale_2 );


            // aggiorna risultati
            $up_1 = Result::find($result_1_id);
            $up_1->result = $totale_finale_1;
            $up_1->goal = $goal_fatti_1;
            $up_1->save();

            $up_2 = Result::find($result_2_id);
            $up_2->result = $totale_finale_2;
            $up_2->goal = $goal_fatti_2;
            $up_2->save();


            // check conteggi
            /*
            echo $partita->team_1_id;
            echo '('. $totale_partita[$partita->team_1_id]['totaleSquadra'] .'-'.$totale_partita[$partita->team_2_id]['modificatoreModulo'] .')';
            echo ' = ' . $totale_finale_1;
            echo ' - ';
            echo $partita->team_2_id;
            echo '('. $totale_partita[$partita->team_2_id]['totaleSquadra'] .'-'.$totale_partita[$partita->team_1_id]['modificatoreModulo'] .')';
            echo ' = ' . $totale_finale_2;
            echo '<br>';
            */

        });

    }



    private function aggiornaClassifica($giornata,$stagioneId=0)
    {

        if($giornata > 0) {
            // recupera ultima giornata
            $calendario_last_giornata = $giornata - 1;

            // duplica classifica corrente
            $classifica_duplica = Classifica::where('giornata',$calendario_last_giornata)->get();

            // aggiorna giornata nella riga duplicata
            foreach($classifica_duplica as $c){
                $new = $c->replicate();
                $new->giornata = $giornata;
                $new->save();
            }

            // recupera classifica
            $classifica = Classifica::where('giornata',$giornata)->get();

        } else {
            // recupera classifica
            $classifica = Classifica::all();
        }


        // recupera calendario e risultati
        $calendario = Calendario::matches($giornata)->get();

        // recupera classifica
        $classifica = Classifica::all();

        foreach ($calendario as $m) {

            $team_1_id      = $m->idTeam1;
            $team_2_id      = $m->idTeam2;
            $team_1_name    = $m->team1;
            $team_2_name    = $m->team2;
            $team_1_result  = $m->resultTeam1;
            $team_2_result  = $m->resultTeam2;
            $team_1_goal    = $m->goalTeam1;
            $team_2_goal    = $m->goalTeam2;

            $winnerId = $this->checkMatchWinner($m);

            // dd($giornata,$stagioneId);

            // Estrai dati classifica team1 e team2
            $classificaTeam1 = Classifica::where('team_id', $team_1_id)->where('giornata',$giornata);
            $classificaTeam2 = Classifica::where('team_id', $team_2_id)->where('giornata',$giornata);

            $t1 = $classificaTeam1->first();
            $t2 = $classificaTeam2->first();

            // aggiorna vinte,nulle,perse
            if($winnerId == $team_1_id){
                $t1->increment('vinte');
                $t2->increment('perse');
            } elseif($winnerId == 0){
                $t1->increment('nulle');
                $t2->increment('nulle');
            } else {
                $t1->increment('perse');
                $t2->increment('vinte');
            }

            /* Aggiorna team 1 */

                // 1. aggiorna gol fatti
                // 2. aggiorna gol subiti (gol fatti dall'avversario)
                // 3. aggiorna punti, giornata e stagione_id
                $t1->increment('gf',$team_1_goal);
                $t1->increment('gs',$team_2_goal);
                $t1->increment('fp',$team_1_result);
                $classificaTeam1->update([
                        //'giornata' => $giornata,
                        'stagione_id' => $stagioneId,
                    ]);


            /* Aggiorna team 2 */

                // 1. aggiorna gol fatti
                // 2. aggiorna gol subiti (gol fatti dall'avversario)
                // 3. aggiorna punti, giornata e stagione_id
                $t2->increment('gf',$team_2_goal);
                $t2->increment('gs',$team_1_goal);
                $t2->increment('fp',$team_2_result);
                $classificaTeam2->update([
                        //'giornata' => $giornata,
                        'stagione_id' => $stagioneId,
                    ]);

        }


        /* Aggiorna posizioni in classifca */
        $pos = Classifica::getClassifica();
        if($pos) {
            // setta posizione
            $posizione = 1;
            foreach ($pos as $p) {

                // aggiorna posizione
                $p->posizione = $posizione;
                $p->save();

                // incrementa posizione
                $posizione++;

            }
        }


    }


    /**
     * @param Calendario $match
     * @return int  winner team id (0 se pareggio)
     */
    private function checkMatchWinner(Calendario $match){

        switch(true){

            case ($match->goalTeam1 > $match->goalTeam2):
                $winnerId = $match->idTeam1;
                break;

            case ($match->goalTeam1 == $match->goalTeam2):
                $winnerId = 0;
                break;

            case ($match->goalTeam1 < $match->goalTeam2):
                $winnerId = $match->idTeam2;
                break;

        }

        return $winnerId;

    }





    private function calcolaGoals($punteggio=0){

        switch(true){

            case $punteggio < 66:
                $goal = 0;
                break;

            case ($punteggio >= 66 AND $punteggio <= 71.5):
                $goal = 1;
                break;

            case ($punteggio >= 72 AND $punteggio <= 77.5):
                $goal = 2;
                break;

            case ($punteggio >= 78 AND $punteggio <= 83.5):
                $goal = 3;
                break;

            case ($punteggio >= 84 AND $punteggio <= 89.5):
                $goal = 4;
                break;

            case ($punteggio >= 90 AND $punteggio <= 94.5):
                $goal = 5;
                break;

            case ($punteggio >= 95 AND $punteggio <= 100.5):
                $goal = 6;
                break;

            case ($punteggio >= 101 AND $punteggio <= 106.5):
                $goal = 7;
                break;

            case ($punteggio >= 107 AND $punteggio <= 112.5):
                $goal = 8;
                break;

            case ($punteggio >= 113 AND $punteggio <= 118.5):
                $goal = 9;
                break;

            case ($punteggio >= 119 AND $punteggio <= 124.5):
                $goal = 10;
                break;

            case ($punteggio >= 125 AND $punteggio <= 130.5):
                $goal = 11;
                break;

            case ($punteggio >= 131 AND $punteggio <= 136.5):
                $goal = 12;
                break;

            case ($punteggio >= 137 AND $punteggio <= 142.5):
                $goal = 13;
                break;

            case ($punteggio >= 143 AND $punteggio <= 148.5):
                $goal = 14;
                break;

            default:
                $goal = 0;

        }

        return $goal;

    }


    public function postSaveNewResult(Request $request)
    {
        if($request->input('confirm') === 'CONFIRM') {

            $v = Validator::make($request->all(), [
                'giornata' => 'required',
                'match' => 'required',
                'team_id' => 'required',
                'new_result' => 'required|numeric',
            ]);

            if ($v->fails())
            {
                return redirect()->back()->withErrors($v->errors());
            }

            $res = Result::whereGiornataAndTeamsId($request->input('giornata'),$request->input('team_id'))->first();
            if($res->result <> $request->input('new_result')) {
                $res->result = $request->input('new_result');
                $res->save();
            }

            $msg = 'Risultato Aggiornato Correttamente!';
            $msgType = 'success';

        } else {

            $msg = 'Operazione non confermata!';
            $msgType = 'warning';

        }


        return redirect('admin/calendario/match/'.$request->input('match'))
            ->with('message', $msg)
            ->with('messageType',$msgType);

    }



}
