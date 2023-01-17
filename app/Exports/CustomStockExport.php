<?php

namespace App\Exports;

use App\Models\Agent;
use App\Models\CustomStock;
use App\Models\Stock;
use App\Models\Visitor;
use App\Models\VisitorAttend;
use App\Models\WorkShop;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CustomStockExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
//    public function collection()
//    {
//        $report=collect();
////        $agents=Agent::all();
//        $ss=Stock::select('agency1')->where('enter',1)->where([['agency1','!=',0],['agency2','=',0]])->pluck('agency1');
//        $stocks=Stock::where('enter',1)->whereNotIn('id',$ss)->where([['agency1','=',0],['agency2','=',0]])->get();
//        foreach ($stocks as $stock){
//            $cautom=new CustomStock();
//            $cautom->setAttribute('name',$stock->full_name);
//            $cautom->setAttribute('orginal',$stock->stock_number);
//            $cautom->setAttribute('agency1',0);
//            $cautom->setAttribute('agency2',0);
//            $cautom->setAttribute('all',$stock->sock_number);
//            $report->add($cautom);
//        }
//        $v=VisitorAttend::select('visitor_id')->pluck('visitor_id');
//        $report=Visitor::all();
//        return $report;
//
//    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        foreach (WorkShop::all() as $item){
            $sheets[] = new InvoicesPerSheet($item);
        }

        return $sheets;
    }
}
