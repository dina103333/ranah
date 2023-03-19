<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToArray;

class ProdutTemplateImport implements ToArray
{
    /**
    * @param Collection $collection
    */
    public function array(array $rows){
        return array_slice($rows, 1);
    }
}
