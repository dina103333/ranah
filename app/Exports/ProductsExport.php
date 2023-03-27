<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::with('company','category')->get();
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->company->name,
            $product->category->name,
            $product->selling_type,
            $product->wholesale_type,
            $product->item_type,
            $product->wholesale_quantity_units,
        ];
    }

    public function headings(): array
    {
        return ["#","االمنتج", "الشركه","الفئه","طريقه البيع","الجمله","القطاعى","عدد الوحدات فى الجمله"];
    }
}
