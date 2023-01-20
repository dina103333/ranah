<?php

namespace App\Exports;

use App\Models\Seller;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SellersExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Seller::all();
    }

    public function map($seller): array
    {
        return [
            $seller->name,
            $seller->mobile_number,
            $seller->address,
        ];
    }

    public function headings(): array
    {
        return ["Name", "Mobile Number", "Address"];
    }
}
