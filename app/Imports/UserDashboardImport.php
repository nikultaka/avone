<?php

namespace App\Imports;

use App\Models\UserDashboard;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class UserDashboardImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
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
            'user_id'                   => '$this->user_id',
            'networkAssessmentFindings' => 'Network Assessment Findings',
            'severity'                  => 'Severity',
            'cve_cwe'                   => 'CVE/CWE',
            'cvss3'                     => 'CVSS3',
            'description'               => 'Description',
            'buisness_impact'           => 'Buisness Impact',
            'published_exploit'         => 'Published Exploit',
            'recommendation'            => 'Recommendation',
            'monitor_your_threat'       => 'Monitor Your Threat'
        ]);
    }
}
