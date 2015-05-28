<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Moduli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModuliController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $moduli = Moduli::all()->sortByDesc('modificatore');

        return view('pages.admin.moduli.index',[
            'moduli' => $moduli
        ]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{

        $this->validate($request, [
            'modulo' => 'required',
            'modificatore' => 'required|numeric',
        ]);

        $modulo = new Moduli();
        $modulo->name = $request->input('modulo');
        $modulo->modificatore = $request->input('modificatore');
        $modulo->save();

        return redirect('admin/moduli')
            ->with('message', 'Modulo Creato!')
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
        return view('pages.admin.moduli.create');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $moduli = Moduli::all();
        $modulo = Moduli::find($id);

        return view('pages.admin.moduli.index',[
            'moduli' => $moduli,
            'modulo' => $modulo,
        ]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
        $this->validate($request, [
            'modulo' => 'required',
            'modificatore' => 'required|numeric',
        ]);

        $modulo = Moduli::find($id);
        $modulo->name = $request->input('modulo');
        $modulo->modificatore = $request->input('modificatore');
        $modulo->save();

        return redirect('admin/moduli')
            ->with('message', 'Modulo modificato con successo!')
            ->with('messageType','success');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy(Request $request, $id)
    {

        if($request->input('confirmDelete') == 'DELETE'):

            $m = Moduli::find($id);
            $m->delete();

            return redirect('admin/moduli')
                ->with('message', 'Modulo Eliminato!')
                ->with('messageType','success');

        endif;

        return redirect('admin/moduli')
            ->with('message', 'Modulo NON ELIMINATO!')
            ->with('messageType','warning');

    }

}
