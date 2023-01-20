<?php

namespace App\Exports;

use App\Models\Driver;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DriversExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Driver::all();
    }

    public function map($driver): array
    {
        return [
            $driver->name,
            $driver->mobile_number,
            $driver->address,
        ];
    }

    public function headings(): array
    {
        return ["Name", "Mobile Number", "Address"];
    }
}
