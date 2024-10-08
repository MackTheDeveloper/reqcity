<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CategoriesImport implements ToCollection
{
    private $common = array();

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $data = [];
        foreach ($rows as $row)
        {
            if($row[0] == "category_name" || $row[1] == "description" || $row[2] == "Status" )
            {
                continue;
            }
            $data[] = array($row[0],$row[1],$row[2]);
        }

        $this->common = $data;

    }

    public function getCommon(): array
    {
        return $this->common;
    }

}
