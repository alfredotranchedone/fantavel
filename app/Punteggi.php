<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Punteggi extends Model {

    protected $fillable = [
        'stagione_id',
        'giornata',
        'players_codice',
        'voto',
        'quotazione',
        'stato',
        'magic_punti',
        'gol',
        'ammonizione',
        'espulsione',
        'rigori',
        'autogol',
        'assist'];

    protected $table = 'punteggi';



}
