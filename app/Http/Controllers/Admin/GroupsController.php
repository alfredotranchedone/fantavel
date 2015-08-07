<?php namespace App\Http\Controllers\Admin;

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

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{

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
