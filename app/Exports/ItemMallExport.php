<?php

namespace App\Exports;

use App\Models\ItemLog;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class ItemMallExport implements FromCollection, WithHeadings,
    WithMapping, WithColumnFormatting, WithColumnWidths, ShouldAutoSize
{

    public function __construct()
    {
        // construction
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ItemLog::all();
    }

    public function headings(): array
    {
        return ["Transaction ID", "User ID", "User Name", "Item ID", "Item Name", "Quantity", "Item Price", "Total Price", "Date Purchased"];
    }

    public function map($row): array{
        return [
            $row->transactionid,
            $row->userid,
            $row->itemid,
            User::find($row->userid)->id_loginid,
            $row->name,
            $row->quantity,
            $row->price,
            $row->total,
            Date::dateTimeToExcel($row->date_purchased),
        ];
    }

    public function columnFormats(): array
    {
        return [
//            'F' => 'm/d/y h:mm AM/PM',
//            'H' => '#,##0.00 [$IDR]_-',
//            'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
//            'J' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'G' => '#,##0.00 [$IDR]_-',
            'H' => '#,##0.00 [$IDR]_-',
            'I' => 'm/d/y h:mm AM/PM',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'E' => 50,
            'G' => 20,
            'H' => 20,
        ];
    }
}
