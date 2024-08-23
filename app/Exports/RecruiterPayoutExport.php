<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\RecruiterPayouts;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use App\Models\Fan;
use Auth;
use Request;

class RecruiterPayoutExport implements FromArray, WithHeadings, WithStyles
// class FansExport implements FromCollection, WithHeadings, WithStyles
{
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }

    public function headings(): array
    {
        return [
            'Recruiter',
            'Amount',
            'Payment ID',
            'Bank Name',
            'Bank Address',
            'Bank City',
            'Bank Country',
            'Account Number',
            'Swift Code',
            'Created At',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    // public function collection()
    public function array(): array
    {
        $request = Request::all();
        $search = $request['search'];
        $startDate = $request['startDate'];
        $endDate = $request['endDate'];
        $recruiter = $request['fil_recruiter'];
        $query = RecruiterPayouts::select('recruiter_payouts.*','recruiters.first_name','recruiters.last_name')
                                    ->leftJoin("recruiters","recruiter_payouts.recruiter_id","recruiters.id")
                                    ->whereNull('recruiter_payouts.deleted_at');
        if ($search != '') {
            $query->where(function ($query2) use ($search) {
              $query2->where('recruiters.first_name', 'like', '%' . $search . '%')
              ->orWhere('recruiters.last_name', 'like', '%' . $search . '%')
              ->orWhere('recruiter_payouts.payment_id', 'like', '%' . $search . '%');
            });
          }
        if (!empty($startDate) && !empty($endDate)) {
            $startDate = date($startDate);
            $endDate = date($endDate);
            $query = $query->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('recruiter_payouts.created_at', [$startDate, $endDate]);
            });
        }
        if (isset($recruiter) && $recruiter!='all') {
            //$filteredq = $filteredq->where('recruiter_payouts.recruiter_id', $request->recruiter);
            $query = $query->where('recruiter_payouts.recruiter_id', $recruiter);
        }
        $query = $query->get();
        $data = [];
        foreach ($query as $key => $value)
        {
          $bankHtml=$value->bank_name.'<br>'.$value->bank_address;
          $bankDetails ='Account Number: '.$value->account_number.'<br>';
          $bankDetails.='Swift Code: '.$value->swift_code.'<br>';
          $bankDetails.='City: '.$value->bank_city.'<br>';
          $bankDetails.='Country: '.$value->bank_country;
            $data[] = [$value->first_name.' '.$value->last_name,'$'.$value->amount, $value->payment_id,$value->bank_name,$value->bank_address,$value->bank_city,$value->bank_country,$value->account_number,$value->swift_code,getFormatedDate($value->created_at)];
        }
        return $data;
    }
}
