<?php

namespace App\Exports;

use App\Product;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProductsExport implements FromQuery, WithHeadings, WithMapping, WithColumnWidths, ShouldAutoSize
{
    use Exportable;

    public $institution_name;

    public function __construct($institution_name)
    {
        $this->institution_name = $institution_name;
    }

    public function query()
    {
        return Product::query();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            [
                'Master Data',
                $this->institution_name,
                Carbon::now()->format('Y-m-d'),
                Carbon::now()->format('H:i')
            ],
            [
                'ID',
//                ucwords('institution'),
//                ucwords('category'),
                ucwords('name'),
                ucwords('stock'),
                ucwords('noted'),
            ]
        ];
    }

    /**
     * @var Product $product
     */
    public function map($product): array
    {
        return [
            $product->id,
//            $product->institution->name,
//            $product->product_category->name,
            $product->name,
            $product->stock,
            $product->noted,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 50,
            'C' => 15,
            'D' => 100,
        ];
    }
}
