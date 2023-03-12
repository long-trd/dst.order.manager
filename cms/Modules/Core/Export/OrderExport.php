<?php

namespace Cms\Modules\Core\Export;

use Cms\Modules\Core\Services\Contracts\OrderServiceContract;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromCollection, WithHeadings
{
    protected $orderService;
    protected $filter;

    public function __construct(OrderServiceContract $orderService, $filter)
    {
        $this->orderService = $orderService;
        $this->filter = $filter;
    }

    public function collection()
    {
        return $this->orderService->downloadExcel($this->filter);
    }

    public function headings(): array
    {
        return [
            'Information',
            'Ebay URL',
            'Product URL',
        ];
    }
}