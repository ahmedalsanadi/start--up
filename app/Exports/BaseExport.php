<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

abstract class BaseExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $data;
    protected $columns;

    public function __construct(Collection $data, array $columns)
    {
        $this->data = $data;
        $this->columns = $columns;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return array_values($this->columns);
    }

    public function map($row): array
    {
        $mapped = [];
        foreach (array_keys($this->columns) as $column) {
            $mapped[] = $this->formatValue($row, $column);
        }
        return $mapped;
    }

    protected function formatValue($row, $column)
    {
        $value = data_get($row, $column);

        // Add custom formatting based on column type
        if (str_contains($column, 'date') || $column === 'created_at' || $column === 'updated_at') {
            return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i') : '';
        }

        if (str_contains($column, 'status')) {
            return __("status.{$value}"); // Translate status if needed
        }

        return $value;
    }

    public function styles(Worksheet $sheet)
    {
        // Set the entire sheet to RTL
        $sheet->setRightToLeft(true);

        // Style the header row
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4A5568'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],
        ]);

        // Auto-size columns
        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Apply RTL alignment to all cells
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],
        ]);

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
