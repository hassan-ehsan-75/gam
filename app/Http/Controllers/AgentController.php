<?php

namespace App\Http\Controllers;

use App\Exports\CustomStockExport;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\CustomStock;
use App\Models\Gathering;
use App\Models\Setting;
use App\Models\Stock;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AgentController extends Controller
{
    public function index($gathering=0,$bank=0,$branch=0){
        if (request('search')) {
            $attr = request()->validate(['search' => 'max:255']);
            $stocks = Agent::where([['full_name', 'like', '%' . $attr['search'] . '%']])
                ->Orwhere([['father', 'like', '%' . $attr['search'] . '%']])
                ->Orwhere([['mother', 'like', '%' . $attr['search'] . '%']])
                ->Orwhere([['p_number',  $attr['search'] ]])
                ->Orwhere([['mobile',  $attr['search'] ]]);
        }else{
            $stocks=Agent::orderBy('id','desc');
        }

        if ($gathering==0) {
            $gathering = Gathering::orderBy('id', 'desc')->where('status',1)->first()->id;
            $stocks=$stocks->where('gathering_id',$gathering);
        }
        else
            $stocks=$stocks->where('gathering_id',$gathering);

        $stocks=$stocks->paginate(10);

        return view('import.agents',compact(['stocks','gathering']));
    }

    public function create($type){
        return view('import.active',['type'=>$type]);
    }
    public function store(Request $request,$type){
        $setting=Setting::first();
        if ($type==1){
            $this->validate($request,[
                'agents'=>'required',
                'p_number'=>'required',
            ]);

            $stock=Stock::where('p_number',$request->p_number)->first();
            if (!$stock){
                return redirect()->back()->with(['error'=>'الرقم  الوطني للمفوض غير موجود']);
            }

            if($setting->first_gathering==1) {
                $stock->present = 1;
                $stock->enter = 1;

                $stocks = Stock::whereIn('p_number', $request->agents)->get();
                $stock_number = Stock::whereIn('p_number', $request->agents)->sum('stock_number');
                if ((($stock_number / $setting->stocks_count) * 100) > 10) {
                    return redirect()->back()->with(['error' => 'مجموع النسب اكبر من 10%']);
                }

                if ($request->hasFile('file')){
                    $stock->stock_file=$request->file('file')->store('public/stocks');
                }
                foreach ($stocks as $stock2){
                $stock2->enter = 1;
                $stock2->present = 1;
                $stock2->agency1=$stock->id;
                $stock2->stock_file=$stock->stock_file;
                $stock2->save();

                }
                $stock->save();

            }
        }else{
            $request->request->add(['gathering_id'=>Gathering::select('id')->where('status',1)->first()->id]);
            if ($request->p_number==null){
                $request->request->add(['p_number'=>'-']);
            }
            $agent=Agent::create($request->except('file','_token','agents','print'));
            $stocks = Stock::whereIn('p_number',$request->agents)->get();
            $stock_number = Stock::whereIn('p_number',$request->agents)->sum('stock_number');
            if ((($stock_number / $setting->stocks_count) * 100) > 10) {
                return redirect()->back()->with(['error' => 'مجموع النسب اكبر من 10%']);
            }

            if ($request->hasFile('file')){
                $file=$request->file('file')->store('public/stocks');
            }
            foreach ($stocks as $stock2){
                $stock2->agency2=$agent->id;
                $stock2->enter = 1;
                $stock2->present = 1;
                $stock2->agency2=$agent->id;
                if ($request->hasFile('file')){
                    $stock2->stock_file=$file;
                }
                $stock2->save();
            }

        }
            if ($type==1)
                return redirect()->back()->with(['success'=>'تمت العملية بنجاح','print'=>route('stock.print',[$stock->id,1])]);
            else
                return redirect()->back()->with(['success'=>'تمت العملية بنجاح','print'=>route('stock.print',[$agent->id,2])]);


    }

    public function export(){
        return Excel::download(new CustomStockExport, 'report.xlsx');
//        return (new CustomStockExport())->download('report.xlsx');
    }
}
