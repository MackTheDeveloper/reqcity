<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Candidate;
use App\Models\CandidateResume;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use App\Models\Fan;
use Auth;
use Request;

class CandidateListExport implements FromArray, WithHeadings, WithStyles
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
            'Job Title',
            'Country',
            // 'State',
            'City',
            'Zipcode',
            'Linkedin Profile',
            'Status',
            'Registerd On'
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
        // $company = $request['company_name'];
        $query = Candidate::select('candidates.*','countries.name as countryName')
                            ->leftJoin('countries','candidates.country','countries.id')
                            ->whereNull('candidates.deleted_at');

        
        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('candidates.first_name', 'like', '%' . $search . '%')
                    ->orWhere('candidates.last_name', 'like', '%' . $search . '%')
                    ->orWhere('candidates.job_title', 'like', '%' . $search . '%');
            });

        }                            
        if ($status) {
            $query = $query->where('candidates.status', $status);
        }
        if (!empty($startDate) && !empty($endDate)) {
            $startDate = date($startDate);
            $endDate = date($endDate);
            $query = $query->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('candidates.created_at', [$startDate, $endDate]);
            });
        }
        // if ($company && $company!='all') {
        //     $query = $query->where('companies.id', $company);
        // }
        $query = $query->get();
        $data = [];
        foreach ($query as $key => $value)
        {
            $isActive = $value->status;
            if($value->status == 1){
                $isActive = "Active";
            }
            elseif($value->status == 2 ){
                $isActive = "Inactive";
            }
            elseif($value->status == 3 ){
                $isActive = "Suspended";
            }
            $data[] = [$value->first_name.' '.$value->last_name, $value->email,$value->phone_ext.'-'.$value->phone ,$value->job_title,$value->countryName,$value->city,$value->postcode,$value->linkedin_profile_link,$isActive,getFormatedDate($value->created_at) ];
        }
        return $data;
    }
}
