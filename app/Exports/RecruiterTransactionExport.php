<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\RecruiterTransaction;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use App\Models\Fan;
use Auth;
use Request;

class RecruiterTransactionExport implements FromArray, WithHeadings, WithStyles
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
            'Name',
            'Email',
            'Phone',
            'Plan',
            'Recruiter',
            'Amount',
            'Payment ID',
            'Status',
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
        //$search = $request['search'];
        $startDate = $request['startDate'];
        $endDate = $request['endDate'];
        $status = $request['status'];
        $plan = $request['sub_plan'];
        $query = RecruiterTransaction::select('recruiter_transactions.*','subscription_plans.subscription_name','users.firstname','users.lastname','recruiters.phone as rec_phone','recruiters.phone_ext as rec_phoneExt','users.email as user_email')
                                    ->leftJoin("subscription_plans", "recruiter_transactions.subscription_plan_id","subscription_plans.id")
                                    ->leftJoin("recruiters","recruiter_transactions.recruiter_id","recruiters.user_id")
                                    ->leftJoin("users","recruiter_transactions.recruiter_id","users.id")
                                    ->whereNull('recruiter_transactions.deleted_at');


        if ($status) {
            $query = $query->where('recruiter_transactions.status', $status);
        }
        if (!empty($startDate) && !empty($endDate)) {
            $startDate = date($startDate);
            $endDate = date($endDate);
            $query = $query->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('recruiter_transactions.created_at', [$startDate, $endDate]);
            });
        }
        if ($plan && $plan!='all') {
            $query = $query->where('recruiter_transactions.subscription_plan_id', $plan);
        }
        $query = $query->get();
        $data = [];
        foreach ($query as $key => $value)
        {
            $isActive = ($value->status)?'Paid':'Failed';
            $data[] = [$value->name, $value->user_email,$value->rec_phoneExt.'-'.$value->rec_phone,$value->subscription_name,$value->firstname.' '.$value->lastname,$value->amount, $value->invoice_number,$isActive ,getFormatedDate($value->created_at)];
        }
        return $data;
    }
}
