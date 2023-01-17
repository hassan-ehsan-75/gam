<?php

namespace App\Imports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StocksImport implements ToModel
{
    /**
     * StocksImport constructor.
     */
    private $gathering;

    public function __construct($gathering)
    {
        $this->gathering=$gathering;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {

        if($row[0]!=null) {
            return new Stock([
                'id' => $row[1],
                'full_name' => $row[2],
                'user_id' => 1,
                'mobile' => $row[17],
                'phone' => $row[16],
                'father' => $row[9],
                'mother' => $row[10],
                'birthday' => $row[4],
                'p_number' => $row[3],
                'nation' => $row[13],
                'total' => $row[25],
                'stock_number' => $row[24],
                'gathering_id' => $this->gathering
            ]);
        }
    }
//
//    /**
//     * @return int
//     */
//    public function startRow(): int
//    {
//        return 2;
//    }
}
