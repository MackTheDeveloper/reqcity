<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\CompanyTransaction;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use App\Models\Fan;
use Auth;
use Request;

class CompanyTransactionExport implements FromArray, WithHeadings, WithStyles
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
            'Conmpany',
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
        $query = CompanyTransaction::select('company_transactions.*','subscription_plans.subscription_name','companies.name as companyName','company_user.phone as userPhone', 'company_user.phone_ext as userPhonePrefix')
                                    ->leftJoin("subscription_plans", "company_transactions.subscription_plan_id","subscription_plans.id")
                                    ->leftJoin("companies","company_transactions.company_id","companies.user_id")
                                    ->leftJoin("users","company_transactions.company_id","users.id")
                                    ->leftJoin("company_user", "company_user.user_id", "users.id")
                                    ->whereNull('company_transactions.deleted_at');

      
        if ($status) {
            $query = $query->where('company_transactions.status', $status);
        }
        if (!empty($startDate) && !empty($endDate)) {
            $startDate = date($startDate);
            $endDate = date($endDate);
            $query = $query->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('company_transactions.created_at', [$startDate, $endDate]);
            });
        }
        if ($plan && $plan!='all') {
            $query = $query->where('company_transactions.subscription_plan_id', $plan);
        }
        $query = $query->get();
        $data = [];
        foreach ($query as $key => $value)
        {
            $isActive = ($value->status == 'paid')?'Paid':'Failed';
            $data[] = [$value->name, $value->email, $value->userPhonePrefix.'-'.$value->userPhone,$value->subscription_name,$value->companyName,$value->amount, $value->invoice_number,$isActive ,getFormatedDate($value->created_at)];
        }
        return $data;
    }
}
