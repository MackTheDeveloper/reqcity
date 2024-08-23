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
use App\Models\RecruiterBankDetail;
use Auth;
use Request;

class RecruiterBankDetailsExport implements FromArray, WithHeadings, WithStyles
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
            'Currency Code',
            'Bank Name',
            'Account Number',
            'Swiftcode',
            'Bank Address',
            'Bank City',
            'Bank Country'
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
        // $company = $request['company_name'];
        $query = RecruiterBankDetail::select('recruiter_bank_details.*', 'countries.name as countryName', 'recruiters.first_name', 'recruiters.last_name')
            ->leftJoin('recruiters', 'recruiter_bank_details.recruiter_id', 'recruiters.id')
            ->leftJoin('countries', 'recruiter_bank_details.bank_country', 'countries.id')
            ->whereNull('recruiter_bank_details.deleted_at');



        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('recruiters.first_name', 'like', '%' . $search . '%')
                    ->orWhere('recruiters.last_name', 'like', '%' . $search . '%')
                    ->orWhere('recruiter_bank_details.bank_name', 'like', '%' . $search . '%')
                    ->orWhere('recruiter_bank_details.account_number', 'like', '%' . $search . '%')
                    ->orWhere('recruiter_bank_details.swift_code', 'like', '%' . $search . '%');
            });
        }
       
        $query = $query->get();
        $data = [];
        foreach ($query as $key => $value) {
            $data[] = [$value->first_name . ' ' . $value->last_name, $value->currency_code ,$value->bank_name, $value->account_number,$value->swift_code,$value->bank_address,$value->bank_city,$value->countryName];
        }
        return $data;
    }
}
