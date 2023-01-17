<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reasons=Reason::orderBy('id','desc');
        $reasons=$reasons->paginate(10);
        return view('reasons.index',['reasons'=>$reasons]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('reasons.create');
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
        ]);
        Reason::create($request->all());
        Session::flash('success','تم الادخال بنجاح');
        return redirect()->route('reasons.index')->with('success','تم الادخال بنجاح');
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
//        return view('reasons.print',['reasons'=>Candidate::where('gathering_id',\request()->gathering)->get()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Reason $record)
    {
        return view('reasons.edit')->with(['reason'=>$record]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request,Reason $record)
    {
        $this->validate($request,[
            'text'=>'required',
        ]);

        $record->update($request->all());
        return redirect()->route('reasons.index')->with('success','تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Reason::where('id',$id)->delete();
        return redirect()->back()->with('success','تم الحذف بنجاح');
    }
}
