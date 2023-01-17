<?php

namespace App\Http\Controllers;

use App\Helpers\SendMessage;
use App\Http\Controllers\Controller;
use App\Imports\StocksImport;
use App\Models\Agent;
use App\Models\Candidate;
use App\Models\Employee;
use App\Models\Gathering;
use App\Models\Record;
use App\Models\RecordAnswer;
use App\Models\Setting;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Importer;

class ImportController extends Controller
{

    public function index($gathering=0,$bank=0,$branch=0){
        if (request('search')) {
            $attr = request()->validate(['search' => 'max:255']);
            $stocks = Stock::where([['full_name', 'like', '%' . $attr['search'] . '%']])
                ->Orwhere([['last_name', 'like', '%' . $attr['search'] . '%']])
                ->Orwhere([['father', 'like', '%' . $attr['search'] . '%']])
                ->Orwhere([['mother', 'like', '%' . $attr['search'] . '%']])
                ->Orwhere([['city', 'like', '%' . $attr['search'] . '%']])
                ->Orwhere([['id',  $attr['search'] ]])
                ->Orwhere([['p_number',  $attr['search'] ]])
                ->Orwhere([['mobile',  $attr['search'] ]])
                ->with( 'bank','user');
        }else{
            $stocks = Stock::with([ 'bank','user']);
        }

        $type=request()->type;
        if ($type&&$type!=0){
            $stocks=$stocks->where('type',$type);
        }
        if($bank!=0){
            $stocks=$stocks->where('bank_id',$bank);
        }
        if ($branch!=0){
            $users=Employee::select('id')->where('branch_id',$branch)->pluck('id');
            $stocks=$stocks->whereIn('user_id',$users);
        }
        if ($gathering==0) {
            $gathering = Gathering::orderBy('id', 'desc')->where('status',1)->first()->id;
            $stocks=$stocks->where('gathering_id',$gathering);
        }
        else
            $stocks=$stocks->where('gathering_id',$gathering);

        $stocks=$stocks->orderBy('id','desc')->paginate(10);

        return view('import.index',compact(['stocks','bank','branch','type','gathering']));
    }

    public function edit($stock){
        $stock=Stock::findOrFail($stock);
        $stock2=null;
        if ($stock->agency1!=0){
            $stock2=Stock::find($stock->agency1);
        }elseif($stock->agency2!=0){
            $stock2=Agent::find($stock->agency2);
        }
        return view('import.edit',['stock'=>$stock,'stock2'=>$stock2]);
    }

    //acticate and deactivate
    public function changePresentStatus($id,$type,Request $request){

        $stock=Stock::findOrFail($id);
        $setting=Setting::first();
        if($type==1) {
            if ($stock->present == 0) {
                $stock->present = 1;
                if($setting->first_gathering==1){
                    $stock->enter = 1;
                }
            }
            else {
                $stock->present = 0;
                $stock->enter = 0;
                $stock->agency1 = 0;
                $stock->agency2 = 0;

                $stocks=Stock::where('agency1',$stock->id)->get();
                
                foreach ($stocks as $item){
                    $item->present = 0;
                    $item->enter = 0;
                    $item->agency1 = 0;
                    $item->agency2 = 0;
                    $item->save();
                }

            }
        }elseif($type==2){
            if ($stock->present == 0) {
                $stock->present = 1;
                if($setting->first_gathering==1){
                    $stock->enter = 1;
                    $stock2=Stock::where('p_number',$request->agent)->first();
                    if (!$stock2){
                        return redirect()->back()->with(['error'=>'الرقم الوطني غير موجود']);
                    }
                    if($stock->user_id!=2){
                        $stock_number = Stock::where('p_number',$request->agent)->sum('stock_number');
                        if ((($stock_number / $setting->stocks_count) * 100) > 10) {
                            return redirect()->back()->with(['error' => 'مجموع النسب اكبر من 10%']);
                        }
                    }
                    $stock->agency1=$stock2->id;
                    $stock2->enter = 1;
                    $stock2->present = 1;
                    $stock2->save();
                }
            }
        }else{
            if ($stock->present == 0){
                $stock->present = 1;
                if($setting->first_gathering==1){
                    $stock->enter = 1;
                }
            }
            $agent=Agent::create($request->except('file','_token','print'));
            $stock->agency2=$agent->id;
        }
        if ($request->hasFile('file')){
            $stock->stock_file=$request->file('file')->store('public/stocks');
        }
        $stock->save();

        return redirect()->back()->with(['success'=>'تمت العملية بنجاح','print'=>$stock->id]);
    }
    public function printStock($id,$type=0){
        if ($type==0) {
            $stock = Stock::with(['agents1','agents2'])->findOrFail($id);
            $stock->present_present = 1;
            $stock->save();
        }elseif($type==2){
            $stock = Agent::findOrFail($id);
            foreach (Stock::where('agency2',$id)->get() as $item){
                $item->present_present = 1;
                $item->save();
            }
        }elseif($type==1){
            $stock = Stock::with(['agents1','agents2'])->findOrFail($id);
            foreach (Stock::where('agency1',$id)->get() as $item){
                $item->present_present = 1;
                $item->save();
            }
        }

        return view('import.singleStock',['stock'=>$stock,'type'=>$type]);
    }
    public function enterStockForm(){
        if(!\request()->gathering)
        return view('import.enter');

        $gathering=\request()->gathering;
        return view('import.enter',['gathering'=>$gathering]);

    }
    public function enterStock(Request $request){
        $validate=Validator::make($request->all(),[
            'data'=>'required'
        ]);
        if ($validate->fails()) {
            return SendMessage::error(301, null, $validate->errors()->first());
        }
        $data=explode(',',$request->data);
        $stock=Stock::where('id',$data[0])->first();
        if (!$stock)
            return SendMessage::error(302, null, 'لا يوجد مساهم بهذا الرقم');
            if($stock->enter==1)
            return SendMessage::error(302, null, 'تم الادخال مسبقا');
        $stock->enter=1;
        $stock->save();
        return SendMessage::success(303,$stock->stock_number,'تم ادخال المساهم :'.$stock->full_name);
    }
    public function getState(){
        $gathering_id=Gathering::orderBy('id','desc')->where('status',1)->first()->id;
        $stock=Stock::where('enter',1)->sum('stock_number');
        $stock1=\App\Models\Stock::where('gathering_id',$gathering_id)->where('agency1',0)->where('agency2',0)->where('enter',1)->orWhere([['enter','=',1],['id','=',4720]])->sum('stock_number');
        $stock2=\App\Models\Stock::where('gathering_id',$gathering_id)->where('agency1','!=',0)->OrWhere('agency2','!=',0)->where('id','!=',4720)->where('enter',1)->sum('stock_number');
        $records=Record::where('gathering_id',$gathering_id)->where('type',2)->withCount(['NoAnswer','YesAnswer'])->get();
        $records=$records->map(function ($record){
            $record['YesCount']=$record->YesAnswerStock($record->id);
            $record['NoCount']=$record->NoAnswerStock($record->id);
           return $record;
        });
        $candidates=Candidate::where('gathering_id',$gathering_id)->with('votes')->get();
        return SendMessage::success(303,['stock'=>$stock,'stock1'=>$stock1,'stock2'=>$stock2,'records'=>$records,'candidates'=>$candidates],"done");
    }
  public function answerForm(){
      if(!\request()->gathering)
          return view('import.answer');

      $gathering=\request()->gathering;
      return view('import.answer',['gathering'=>$gathering]);

    }
    public function answer(Request $request){
        $validate=Validator::make($request->all(),[
            'data'=>'required'
        ]);
        \Log::info($request->all());
        if ($validate->fails()) {
            return SendMessage::error(301, null, $validate->errors()->first());
        }
        $data=explode(',',$request->data);
        
        if ($data[3]==0) {
            $record=RecordAnswer::withOut('stock')->where('stock_id',$data[2])->where('record_id',$data[0])->first();
            if ($record)
                return SendMessage::error(302, null, 'تم الادخال مسبقا');
            RecordAnswer::create([
                'record_id'=>$data[0],
                'answer'=>$data[1],
                'stock_id'=>$data[2],
            ]);
        }elseif ($data[3]==2){

            $stock =Agent::find($data[2]);
            if($stock==null){
                return SendMessage::error(401,null,'الكود  الممسوح خاطئ');
            }
            $stocks=Stock::where('agency2',$data[2])->pluck('id');
            $stockss=Stock::where('agency2',$data[2])->get();
            $records=RecordAnswer::withOut('stock')->whereIn('stock_id',$stocks)->where('record_id',$data[0])->first();
            if ($records)
                return SendMessage::error(302, null, 'تم الادخال مسبقا');
            foreach ($stockss as $st) {
                RecordAnswer::create([
                    'record_id' => $data[0],
                    'answer' => $data[1],
                    'stock_id' => $st->id,
                ]);
            }
        }else{
            $stock =Stock::find($data[2]);
            if($stock==null){
                return SendMessage::error(401,null,'الكود  الممسوح خاطئ');
            }
            $stocks=Stock::where('agency1',$data[2])->pluck('id');
            $stockss=Stock::where('agency1',$data[2])->get();
            $records=RecordAnswer::withOut('stock')->where('stock_id',$stock->id)->where('record_id',$data[0])->first();
            if ($records) {
                return SendMessage::error(302, null, 'تم الادخال مسبقا');
            }else {
                RecordAnswer::create([
                    'record_id' => $data[0],
                    'answer' => $data[1],
                    'stock_id' => $stock->id,
                ]);
                foreach ($stockss as $st) {
                    RecordAnswer::create([
                        'record_id' => $data[0],
                        'answer' => $data[1],
                        'stock_id' => $st->id,
                    ]);
                }
            }
        }


        $count=RecordAnswer::where('record_id',$data[0])->sum('answer');
        $countnot=RecordAnswer::where('record_id',$data[0])->where('answer',0)->count();
        return SendMessage::success(303,['id'=>$data[0],'count'=>$count,'countnot'=>$countnot],'تم ادخال نتيجة التصويت');
    }

    public function changePresentStatus2($id,$type,Request $request)
    {
        $stock = Stock::findOrFail($id);
        $setting = Setting::first();
        if($type==1) {
            if ($stock->present == 0) {
                $stock->present = 1;
                if($setting->first_gathering==1){
                    $stock->enter = 1;
                }
            }
            else {
                $stock->present = 0;
                $stock->enter = 0;
                $stock->agency1 = 0;
                $stock->agency2 = 0;

                $stocks=Stock::where('agency1',$stock->id)->get();
                foreach ($stocks as $item){
                    $item->present = 0;
                    $item->enter = 0;
                    $item->save();
                }

            }
        }
    }
    public function getStock(){
        $name=$_GET['name'];
        $stocks=Stock::select('id','full_name','last_name','stock_number')->where('full_name','like','%'.$name.'%')->Orwhere('last_name','like','%'.$name.'%')->get();
        return response()->json([
           'data'=>$stocks
        ]);
    }

}
