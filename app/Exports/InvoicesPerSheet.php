<?php

namespace App\Exports;

use App\Models\Agent;
use App\Models\CustomStock;
use App\Models\Stock;
use App\Models\Visitor;
use App\Models\VisitorAttend;
use App\Models\VisitorEvaluation;
use App\Models\WorkShop;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;

class InvoicesPerSheet   implements FromQuery, WithTitle
{
    /**
     * InvoicesPerSheet constructor.
     */
    public $work;
    public function __construct(WorkShop $workShop)
    {
        $this->work=$workShop;
    }


    /**
     * @return Builder
     */
    public function query()
    {
        $ids=VisitorEvaluation::select('visitor_id')->where('workshop_id',$this->work->id)->pluck('visitor_id');
        return Visitor::query()->whereIn('id',$ids);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->work->name;
    }
}
