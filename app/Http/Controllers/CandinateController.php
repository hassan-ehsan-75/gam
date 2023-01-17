<?php

namespace App\Http\Controllers;

use App\Helpers\SendMessage;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Candidate;
use App\Models\CandidateVote;
use App\Models\Gathering;
use App\Models\Stock;
use App\Models\VoteMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CandinateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $candidates=Candidate::orderBy('id','desc');
        $gathering=Gathering::where('status',1)->first()->id;
        if ($gathering!=0){
            $candidates=$candidates->where('gathering_id',$gathering);
        }
        if (request()->search){

            $candidates=$candidates->where('file','like','%'.request()->search.'%');
            if($gathering!=0)
                $candidates=$candidates->where('gathering_id',$gathering);

        }
        $candidates=$candidates->paginate(10);
        return view('candidates.index',['candidates'=>$candidates,'gathering'=>$gathering,'search'=>request()->search]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('candidates.create')->with(['gatherings'=>Gathering::where('status',1)->get()]);
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
            'name'=>'required|max:255|min:2',
            'gathering_id'=>'required'
        ]);
        Candidate::create($request->except('person'));
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
        if (!\request()->gathering){
            return redirect()->back()->with('success','الرجاء اختيار رقم الجمعية');
        }
        $stock=0;
        if (request()->stock){
            $stock=\request()->stock;
        }
        $manag=Candidate::where('gathering_id',\request()->gathering)->where('postion','مجلس ادارة')->get();
        $staf=Candidate::where('gathering_id',\request()->gathering)->where('postion','هيئة شرعية')->get();
        $account=Candidate::where('gathering_id',\request()->gathering)->where('postion','مدقق حسابات')->get();
        return view('candidates.print',['manage'=>$manag,'staffs'=>$staf,'accounts'=>$account,'stock'=>$stock]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Candidate $candidate)
    {
        return view('candidates.edit')->with(['gatherings'=>Gathering::where('status',1)->get(),'candidate'=>$candidate]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request,Candidate $candidate)
    {
        $this->validate($request,[
            'name'=>'required|max:255|min:2',
            'gathering_id'=>'required'
        ]);
        if($request->person==1){
            $request->request->add(['person_type'=>$request->person_type_per]);
        }else{
            $request->request->add(['person_type'=>$request->person_type_com]);
        }

        $candidate->update($request->except('person','person_type_per','person_type_com'));
        Session::flash('success','تم التعديل بنجاح');
        return redirect()->back()->with('success','تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Candidate::where('id',$id)->delete();
        return redirect()->back()->with('success','تم الحذف بنجاح');
    }
    public function candidatesVotesForm(){
        if (\request()->gathering){
            $gathering=\request()->gathering;
            return view('candidates.vote',compact('gathering'));
        }
        return view('candidates.vote');
    }

    public function candidatesVotes(Request $request){
        $validate=Validator::make($request->all(),[
            'data'=>'required'
        ]);
        \Log::info($request->all());
        if ($validate->fails()) {
            return SendMessage::error(301, null, $validate->errors()->first());
        }
        $voteRequest=explode(',',$request->data);
        $candidate=Candidate::where('id',$voteRequest[0])->where('gathering_id',$voteRequest[1])->first();
        $vote=CandidateVote::where('candidate_id',$voteRequest[0])->first();
        if ($candidate==null){
            return SendMessage::error(401,null,'هذا المرشح غير موجود');
        }
        if(VoteMember::where('candidate_id',$voteRequest[0])->where('stock_id',$voteRequest[2])->first()){
            return SendMessage::error(401,null,'تم التصويت سابقا');
        }
        if ($voteRequest[3]==0) {
            $stock = Stock::find($voteRequest[2]);
            if($stock==null){
                return SendMessage::error(401,null,'الكود  الممسوح خاطئ');
            }
            $stocks=$stock->stock_number;
        }elseif ($voteRequest[3]==2){
            $stock =Agent::find($voteRequest[2]);
            if($stock==null){
                return SendMessage::error(401,null,'الكود  الممسوح خاطئ');
            }
            $stocks=Stock::where('agency2',$stock->id)->sum('stock_number');
        }else{
            $stock = Stock::find($voteRequest[2]);
            if($stock==null){
                return SendMessage::error(401,null,'الكود  الممسوح خاطئ');
            }
            $stocks=Stock::where('agency1',$stock->id)->sum('stock_number');
            $stocks=$stocks+$stock->stock_number;
        }

        if ($vote==null){
            $vote=CandidateVote::create([
                'candidate_id'=>$voteRequest[0],
                'votes'=>$stocks,
                'stock_id'=>$voteRequest[2],
            ]);

        }else{
            $vote->votes=$vote->votes+$stocks;
            $vote->save();
        }
        if ($voteRequest[3]==0) {
            VoteMember::create([
                'candidate_id'=> $voteRequest[0],
                'stock_id'=> $voteRequest[2],
            ]);
        }elseif ($voteRequest[3]==2){

            $stocks=Stock::where('agency2',$stock->id)->get();
            foreach ($stocks as $stock) {
                VoteMember::create([
                    'candidate_id' => $voteRequest[0],
                    'stock_id' => $stock->id,
                ]);
            }

        }else{
            VoteMember::create([
                'candidate_id' => $voteRequest[0],
                'stock_id' => $voteRequest[2],
            ]);
            $stocks=Stock::where('agency1',$stock->id)->get();
            foreach ($stocks as $stock) {
                VoteMember::create([
                    'candidate_id' => $voteRequest[0],
                    'stock_id' => $stock->id,
                ]);
            }

        }

        
        return SendMessage::success(402,$vote,'تم المسح بنجاح');
    }

}
