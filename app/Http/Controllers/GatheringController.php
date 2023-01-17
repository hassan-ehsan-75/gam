<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gathering;
use App\Models\Record;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GatheringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('gathering.index',['gatherings'=>Gathering::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gathering=Gathering::where('status',1)->first();
        if ($gathering){
            Session::flash('error','لايمكن اضافه جمعيه قبل اغلاق الجمعيه السابقه');
            return redirect()->back()->with('error','لايمكن اضافه جمعيه قبل اغلاق الجمعيه السابقه');
        }
        return view('gathering.create');
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
           'g_date'=>'required',
           'g_time'=>'required',
            'description'=>'required',
           'place'=>'required|max:255',
           'reason'=>'required|max:255',
        ]);
        $prev_gath=Gathering::orderBy('id','desc')->first();
        if ($prev_gath==null){
            $g_number=1;
        }else{
            $g_number=$prev_gath->g_number+1;
        }
        $request->request->add(['g_number'=>$g_number]);
        $gathering=Gathering::create($request->except('records'));

        return redirect()->route('gatherings.index')->with('success','تم الانشء بنجاح');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Gathering $gathering)
    {
        return view('gathering.edit',['gathering'=>$gathering]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request,Gathering $gathering)
    {
        $this->validate($request,[
            'g_date'=>'required',
            'g_time'=>'required',
            'description'=>'required',
            'place'=>'required|max:255',
            'reason'=>'required|max:255',
        ]);

        $gathering->update($request->except('records'));

        return redirect()->back()->with('success','تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Gathering $gathering)
    {
        Record::where('gathering_id',$gathering->id)->delete();
        Stock::where('gathering_id',$gathering->id)->delete();
        $gathering->delete();
        return redirect()->back()->with('success','تم الحذف بنجاح');
    }
    public function closeGathering(Request $request,$id){
        $gathering=Gathering::findOrFail($id);
        $this->validate($request,[
           'file'=>'required'
        ]);

        $gathering->close_file=$request->file('file')->store('public/gather');
        $gathering->status=0;
        $gathering->save();
        return redirect()->back()->with('success','تم اغلاق الجسلة');
    }
}
