<?php namespace App\Http\Controllers\Admin;

use App\Calendario;
use App\Group;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class GroupsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

        $gruppi = Group::all(['id','name']);

        return view('pages.admin.groups.index',[
            'gruppi' => $gruppi
        ]);

	}


	public function getAssocia($id=null)
	{

        $gruppo = Group::find($id);
        $giornate = Calendario::giornate()->get();
        $assoc_start = 0;
        $assoc_end = 0;

        if(!$gruppo->calendario->isEmpty()) {
            $assoc_start = $gruppo->calendario->first()->giornata;
            $assoc_end = $gruppo->calendario->last()->giornata;
        }
        
        return view('pages.admin.groups.associa',[
            'gruppo' => $gruppo,
            'giornate' => $giornate,
            'assoc_start' => $assoc_start,
            'assoc_end' => $assoc_end
        ]);

	}


    public function postAssocia(Request $request)
	{

        $this->validate($request, [
            'id' => 'required',
            'select_giornata_start' => 'required',
            'select_giornata_end' => 'required',
        ]);

        $id = $request->input('id');
        $s = $request->input('select_giornata_start');
        $e = $request->input('select_giornata_end');

        if($e<$s) {
            return redirect('admin/config/groups/associa/'.$id)
                ->with('message', 'La giornata finale deve essere maggiore di quella iniziale!')
                ->with('messageType', 'warning');
        }

        // resetta giornate associate
        $r = Calendario::where('group_id',$id)->get();
        $r->each(function($giornata_da_resettare){
            $giornata_da_resettare->group_id = 0;
            $giornata_da_resettare->save();
        });

        // crea array giornate da associare
        $giornate = [];
        for($s;$s<=$e;$s++){
            $giornate[] = $s;
        }

        // estrai giornate da associare
        $giornate = Calendario::whereIn('giornata',$giornate)->get();

        // salva associazione
        $giornate->each(function($giornata) use ($id){
            $giornata->group_id = $id;
            $giornata->save();
        });

        return redirect('admin/config/groups')
            ->with('message', 'Gruppo Associato Correttamente!')
            ->with('messageType','success');

	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postStore(Request $request)
	{


        $this->validate($request, [
            'name' => 'required',
        ]);

        $g = new Group();
        $g->name = $request->input('name');
        $g->save();

        return redirect('admin/config/groups')
            ->with('message', 'Gruppo Creato!')
            ->with('messageType','success');

    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
        $gruppo = Group::find($id);

        if( is_null($gruppo) )
            return redirect('admin/config/groups');

        return view('pages.admin.groups.edit',[
            'gruppo' => $gruppo
        ]);


	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postUpdate(Request $request)
	{
        $this->validate($request, [
            'name' => 'required',
            'id' => 'required',
        ]);

        $id = $request->input('id');

        $g = Group::find($id);
        $g->name = $request->input('name');
        $g->save();

        return redirect('admin/config/groups')
            ->with('message', 'Gruppo Modificato!')
            ->with('messageType','success');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function anyDestroy(Request $request, $id)
	{
        $g = Group::find($id);

        if($request->input('confirmDelete') == 'DELETE'):

            $m = Group::find($id);
            $m->delete();

            return redirect('admin/config/groups')
                ->with('message', 'Gruppo Eliminato!')
                ->with('messageType','success');

        endif;

        return redirect('admin/config/groups')
            ->with('message', 'Gruppo NON ELIMINATO!')
            ->with('messageType','warning');
	}

}
