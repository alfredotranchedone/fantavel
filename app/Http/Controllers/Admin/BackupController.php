<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\File;

class BackupController extends Controller {

    // relative to storage_path(); come settato in config/filesystem.php
    public $backup_folder = 'backup/';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
        // abort(404);

        $backup_list = Storage::files($this->backup_folder);
        return view('pages.admin.backup.index')->with([
            'backupList' => $backup_list
        ]);
	}



    public function getDatabase(){

        return view('pages.admin.backup.database');

    }



    public function postDatabase(Request $request){

        if( $request->input('confirm') === 'CONFIRM' ):

            if(Config::get('database.default') == 'sqlite'):
                $current_db = last(explode('/',Config::get('database.connections.sqlite.database')));
                $copied_db = $this->backup_folder.time().'_'.$current_db.'.bak';

                if(Storage::disk('local')->exists($current_db)) {

                    Storage::copy($current_db, $copied_db);

                    return redirect('admin/utility/backup')
                        ->with('message','Backup eseguito correttamente.')
                        ->with('messageType','success');

                }

            endif;

        else:
            return redirect()->back()
                ->with('message','Backup non eseguito.')
                ->with('messageType','warning');
        endif;

    }



    public function postDownload(Request $request){

        $filename = \Crypt::decrypt($request->input('file'));

        $file_path = storage_path() .'/'. $filename;
        if (file_exists($file_path))
        {
            // Send Download
            return response()->download($file_path, last(explode('/',$filename)), [
                'Content-Length: '. filesize($file_path)
            ]);
        }

    }




}
