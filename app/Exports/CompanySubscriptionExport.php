<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\CompanySubscription;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use App\Models\Fan;
use Auth;
use Request;

class CompanySubscriptionExport implements FromArray, WithHeadings, WithStyles
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
            'Company Name',
            'Email',
            'Phone',
            'Subscription Plan',
            'Amount',
            'Status',
            'Subscription Number',
            'Subscribed On',
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
        $status = $request['status'];
        $subscription = $request['subscription'];
        $query = CompanySubscription::getSubscriptionDetails();

        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('companies.email', 'like', '%' . $search . '%')
                    ->orWhere('company_subscription.created_at', 'like', '%' . $search . '%');
            });

        }
        if (isset($status)) {
            $query = $query->where('company_subscription.status', $status);
        }
        if (!empty($startDate) && !empty($endDate)) {
            $startDate = date($startDate);
            $endDate = date($endDate);
            $query = $query->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('company_subscription.created_at', [$startDate, $endDate]);
            });
        }
        if ($subscription && $subscription!='all') {
            $query = $query->where('company_subscription.subscription_number', $subscription);
        }
        $query = $query->get();
        $data = [];
        foreach ($query as $key => $value)
        {
            $isActive = ($value->status)?'Paid':'Unpaid';
            $data[] = [$value->name, $value->email, $value->phone,$value->plan_type ,'$'.$value->amount, $isActive ,$value->subscription_number ,getFormatedDate($value->created_at)];
        }
        return $data;
    }
}
