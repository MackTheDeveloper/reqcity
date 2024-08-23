<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\RecruiterSubscription;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use App\Models\Fan;
use Auth;
use Request;

class RecruiterSubscriptionExport implements FromArray, WithHeadings, WithStyles
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
            'Recruiter Name',
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
        $query = RecruiterSubscription::getSubscriptionDetails();

        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('recruiters.first_name', 'like', '%' . $search . '%')
                    ->orWhere('recruiters.last_name', 'like', '%' . $search . '%')
                    ->orWhere('recruiter_subscription.email', 'like', '%' . $search . '%')
                    ->orWhere('recruiter_subscription.created_at', 'like', '%' . $search . '%');
            });

        }
        if (isset($status)) {
            $query = $query->where('recruiter_subscription.status', $status);
        }
        if (!empty($startDate) && !empty($endDate)) {
            $startDate = date($startDate);
            $endDate = date($endDate);
            $query = $query->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('recruiter_subscription.created_at', [$startDate, $endDate]);
            });
        }
        if ($subscription && $subscription!='all') {
            $query = $query->where('recruiter_subscription.plan_type', $subscription);
        }
        $query = $query->get();
        $data = [];
        foreach ($query as $key => $value)
        {
            $isActive = ($value->status)?'Paid':'Unpaid';
            $data[] = [$value->first_name.' '.$value->last_name, $value->email, $value->phone,$value->plan_type ,'$'.$value->amount, $isActive ,$value->subscription_number ,getFormatedDate($value->created_at)];
        }
        return $data;
    }
}
