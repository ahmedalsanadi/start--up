<?php

namespace App\Services;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class ExportService
{
    public function export($data, string $type, array $columns = null)
    {
        $exportClass = "App\\Exports\\" . Str::studly($type) . "Export";

        if (!class_exists($exportClass)) {
            throw new \Exception("Export class for type '{$type}' not found");
        }

        $columns = $columns ?? $exportClass::getDefaultColumns();

        return Excel::download(
            new $exportClass($data, $columns),
            $this->generateFileName($type)
        );
    }

    protected function generateFileName($type): string
    {
        $timestamp = now()->format('Y-m-d-H-i-s');
        return "{$type}-{$timestamp}.xlsx";
    }
}
