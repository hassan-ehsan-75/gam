<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gathering;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RecordController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records=Record::orderBy('id','desc');
        $gathering=\request()->gathering;
        if ($gathering!=0){
            $records=$records->where('gathering_id',$gathering);
        }
        if (request()->search){

            $records=$records->where('file','like','%'.request()->search.'%');
            if($gathering!=0)
                $records=$records->where('gathering_id',$gathering);

        }
        $records=$records->paginate(10);
        return view('records.index',['records'=>$records,'gathering'=>$gathering,'search'=>request()->search]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $id=Gathering::where('status',1)->first();
        if(!$id){
            Session::flash('error','لم يتم اضافه جمعية');
            return redirect()->back()->with('error','لم يتم اضافه جمعية');
        }
        $id=$id->id;
        $last_record=Record::where('gathering_id',$id)->orderBy('id','desc')->first();
        if ($last_record==null){
            $sort=1;
        }else{
            $sort=intval($last_record->sort)+1;
        }
        return view('records.create')->with(['gatherings'=>Gathering::where('status',1)->get(),'sort'=>$sort]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'text'=>'required',
            'description'=>'required',
            'gathering_id'=>'required',
            'type'=>'required'
        ]);
        $last_record=Record::where('gathering_id',$request->gathering_id)->orderBy('id','desc')->first();
        if ($last_record==null){
            $request->request->add(['sort'=>1]);
        }else{
            $request->request->add(['sort'=>(intval($last_record->sort)+1)]);
        }
        Record::create($request->all());
        Session::flash('success','تم الادخال بنجاح');
        return redirect()->back()->with('success','تم الادخال بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
//        if (!\request()->gathering){
//            return redirect()->back()->with('success','الرجاء اختيار رقم الجمعية');
//        }
//
//        return view('records.print',['records'=>Candidate::where('gathering_id',\request()->gathering)->get()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Record $record)
    {
        return view('records.edit')->with(['gatherings'=>Gathering::where('status',1)->get(),'record'=>$record]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request,Record $record)
    {
        $this->validate($request,[
            'text'=>'required',
            'description'=>'required',
            'gathering_id'=>'required',
            'type'=>'required'
        ]);

        $record->update($request->all());
        return redirect()->route('records.index')->with('success','تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Record::where('id',$id)->delete();
        return redirect()->back()->with('success','تم الحذف بنجاح');
    }
}
