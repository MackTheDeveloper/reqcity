<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\CompanyJobFunding;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use App\Models\Fan;
use Auth;
use Request;

class CompanyJobFundingExport implements FromArray, WithHeadings, WithStyles
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
            'Company',
            'Job Title',
            'Amount',
            'Payment Id',
            'Status',
            'Funded On',
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
        $company = $request['company_name'];
        $query = CompanyJobFunding::select('company_job_funding.*','companies.name as companyName','company_jobs.title as jobTitle')
                                    ->leftJoin("company_jobs", "company_job_funding.company_job_id","company_jobs.id")
                                    ->leftJoin("companies","company_job_funding.company_id","companies.id")
                                    ->whereNull('company_job_funding.deleted_at');

        
        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('company_jobs.title', 'like', '%' . $search . '%')
                    ->orWhere('company_job_funding.payment_id', 'like', '%' . $search . '%');
            });

        }                            
        if ($status) {
            $query = $query->where('company_job_funding.status', $status);
        }
        if (!empty($startDate) && !empty($endDate)) {
            $startDate = date($startDate);
            $endDate = date($endDate);
            $query = $query->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('company_job_funding.created_at', [$startDate, $endDate]);
            });
        }
        if ($company && $company!='all') {
            $query = $query->where('companies.id', $company);
        }
        $query = $query->get();
        $data = [];
        foreach ($query as $key => $value)
        {
            $isActive = ($value->status)?'Paid':'Failed';
            if($value->status == 1){
                $isActive = "Completed";
            }
            elseif($value->status == 2 ){
                $isActive = "Pending";
            }
            elseif($value->status == 3 ){
                $isActive = "Failed";
            }
            $data[] = [$value->companyName, $value->jobTitle,'$'.$value->amount,$value->payment_id , $isActive,getFormatedDate($value->created_at) ];
        }
        return $data;
    }
}
