<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class TransactionExport implements FromCollection, WithHeadings,
    WithMapping, WithColumnFormatting, WithColumnWidths, ShouldAutoSize
{
    private $date_start, $date_end;

    public function __construct(string $date_start, string $date_end)
    {
        $this->date_start = date( 'Y-m-d H:i:s', strtotime($date_start));
        $this->date_end = date( 'Y-m-d H:i:s', strtotime($date_end));
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Invoice::where('status_code', '00')
            //->whereBetween('date_created', [$this->date_start, $this->date_end])
            ->whereDate('date_created','>=', $this->date_start)
            ->whereDate('date_created','<=', $this->date_end)
            ->get();
    }

    public function headings(): array
    {
        return ["Transaction ID", "Reference ID",  "User ID", "Username", "Payment Method",
            "Date Issued", "Referral Code", "Price", "Cash Points", "Bonus Points" ];
    }

    public function map($row): array{
        return [
            $row->transaction_id,
            $row->reference,
            $row->user_id,
            User::find($row->user_id)->id_loginid,
            $row->getPaymentMethod(),
            Date::dateTimeToExcel($row->date_created),
            $row->referral_code,
            $row->price,
            $row->cash_points,
            $row->bonus_points,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => 'm/d/y h:mm AM/PM',
            'H' => '#,##0.00 [$IDR]_-',
            'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'J' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'H' => 17,
        ];
    }
}
