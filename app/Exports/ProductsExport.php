<?php

namespace App\Exports;

use App\Product;
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
            'ID',
            ucwords('institution'),
            ucwords('category'),
            ucwords('name'),
            ucwords('stock'),
            ucwords('noted'),
        ];
    }

    /**
     * @var Product $product
     */
    public function map($product): array
    {
        return [
            $product->id,
            $product->institution->name,
            $product->product_category->name,
            $product->name,
            $product->stock,
            $product->noted,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 30,
            'C' => 20,
            'D' => 30,
            'E' => 5,
            'F' => 100,
        ];
    }
}
