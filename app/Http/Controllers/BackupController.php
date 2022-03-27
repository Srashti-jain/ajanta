<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Svg\Tag\Rect;
use App\Http\Controllers\GenralController;
use DotenvEditor;

class BackupController extends Controller
{
    public function get(){

        abort_if(!auth()->user()->can('others.database-backup'),403,__('User does not have the right permissions.'));

        Artisan::call('backup:list');
        
        $html  =   '<pre>';
        $html .=    Artisan::output();
        $html .=   '</pre>';
        
        return view('admin.backup.index',compact('html'));

    }

    public function updatedumpPath(Request $request){

        abort_if(!auth()->user()->can('others.database-backup'),403,__('User does not have the right permissions.'));

        $env_keys_save = DotenvEditor::setKeys([
            'SQL_DUMP_PATH' => $request->SQL_DUMP_PATH
        ]);

        $env_keys_save->save();

        notify()->success(__('SQL dump path updated !'));
        return back();

    }

    public function process(Request $request){

        abort_if(!auth()->user()->can('others.database-backup'),403,__('User does not have the right permissions.'));

        if(env('DEMO_LOCK') == 1){
            notify()->error(__("This action is disabled in demo !"));
            return back();
        }
       
        try{
            
            set_time_limit(0);

            if($request->type == 'all'){
                Artisan::call('backup:run');
            }

            if($request->type == 'onlyfiles'){

                Artisan::call('backup:run --only-files');

            }

            if($request->type == 'onlydb'){

                Artisan::call('backup:run --only-db');

            }

        }catch(\Exception $e){
            notify()->error($e->getMessage());
            return back();
        }

        notify()->success(__('Backup completed !'),__('Done !'));

        return back();

    }

    public function download(Request $request, $filename){

        abort_if(!auth()->user()->can('others.database-backup'),403,__('User does not have the right permissions.'));

        if(env('DEMO_LOCK') == 1){
            notify()->error(__("This action is disabled in demo !"));
            return back();
        }

        if (! $request->hasValidSignature()) {
            notify()->error(__('Download Link is invalid or expired !'));
            return redirect(route('admin.backup.settings'));
        }

        $filePath = storage_path().'/app/'.config('app.name').'/'.$filename;

        $fileContent = file_get_contents($filePath);

        $response = response($fileContent, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);

        return $response;

    }
}
