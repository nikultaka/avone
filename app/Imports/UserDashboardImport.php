<?php

namespace App\Imports;

use App\Models\UserDashboard;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class UserDashboardImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $rowkkkkkkk                                                           
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function  __construct($user_id)
    {
        $this->user_id= $user_id;
    }  

    public function model(array $row)
    {
        return new UserDashboard([
            // 'user_id'                   => $this->user_id,
            // 'networkAssessmentFindings' => $row['Network Assessment Findings'],
            // 'severity'                  => $row['Severity'],
            // 'cve_cwe'                   => $row['CVE/CWE'],
            // 'cvss3'                     => $row['CVSS3'],
            // 'description'               => $row['Description'],
            // 'buisness_impact'           => $row['Buisness Impact'],
            // 'published_exploit'         => $row['Published Exploit'],
            // 'recommendation'            => $row['Recommendation'],
            // 'monitor_your_threat'       => $row['Monitor Your Threat']
        ]);
    }
}
