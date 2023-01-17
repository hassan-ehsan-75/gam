<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\StocksImport;
use App\Models\Gathering;
use App\Models\ImportFile;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportFileController extends Controller
{
    public function importForm(){
        return view('import_files.import')->with(['gatherings'=>Gathering::where('status',1)->get()]);
    }
    public function import(Request $request){
        $file=$request->file('file')->store('temp');
        ImportFile::create([
           'file'=>$file,
            'gathering_id'=>$request->gathering
        ]);
        Excel::import(new StocksImport($request->gathering),$file);


        return redirect()->route('import.home')->with(['success'=>'تم الاستيراد بنجاح']);
    }
    public function index($gathering=0,Request $request){
        $files=ImportFile::orderBy('id','desc');
        if ($gathering!=0){
            $files=$files->where('gathering_id',$gathering);
        }
        if ($request->search){

            $files=$files->where('file','like','%'.$request->search.'%');
                if($gathering!=0)
            $files=$files->where('gathering_id',$gathering);

        }
        $files=$files->paginate(10);
        return view('import_files.index',['files'=>$files,'gathering'=>$gathering,'search'=>$request->search]);
    }

}
