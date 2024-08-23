<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\AdminCommission;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use App\Models\Fan;
use Auth;
use Request;
use DateTime;
use DatePeriod;
use DateInterval;

class AdminCommissionExport implements FromArray, WithHeadings, WithStyles
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
            'Job Title',
            'Job Posted on',
            'Amount',
            'Approved On',
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
        $company = $request['company_name'];
        $query = AdminCommission::select('company_job_commission.*','companies.name as companyName','company_jobs.title as jobTitle','company_job_applications.created_at as jobPosted')
                                    ->leftJoin("company_jobs", "company_job_commission.company_job_id","company_jobs.id")
                                    ->leftJoin("companies","company_jobs.company_id","companies.id")
                                    ->leftJoin("company_job_applications","company_job_commission.company_job_application_id","company_job_applications.id")
                                    ->where('company_job_commission.type',2)
                                    ->whereNull('company_job_commission.deleted_at');

        
        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('company_jobs.title', 'like', '%' . $search . '%');
            });

        }                            
        if (!empty($startDate) && !empty($endDate)) {
            $newDate = new DateTime($endDate);
            $newDate->add(new DateInterval('P1D'));
           
            $query = $query->where(function($q) use ($startDate,$newDate){
                $q->whereBetween('company_job_commission.created_at', [$startDate, $newDate]);
            });
        }
        if ($company && $company!='all') {
            $query = $query->where('companies.id', $company);
        }

        $query = $query->get();
        $data = [];
        foreach ($query as $key => $value)
        {
            
            $data[] = [$value->companyName, $value->jobTitle,getFormatedDate($value->jobPosted),'$'.$value->amount,getFormatedDate($value->created_at)];
        }
        return $data;
    }
}
