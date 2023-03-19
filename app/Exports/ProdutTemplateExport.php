<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ProdutTemplateExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.product.export', [
            'categories' => Category::where('parent_id','!=',null)
            ->whereHas('companies')->with('companies:id,name')->select('id','name')->get()
        ]);
    }
}
