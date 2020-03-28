<?php
namespace App\Http\Requests\research\researcher;
class research_researcherListRequest extends research_researcherRequest
{
    public function getOrderFields()
    {
        $this->getOrderFieldsFromList([
            'user'=>'user_fid',
		'name'=>'name',
		'family'=>'family',
		'university'=>'university',
		'studyfield'=>'studyfield',
		'interestarea'=>'interestarea',
		'telnum'=>'tel_num',
		'mobnum'=>'mob_num',
		'email'=>'email',
		'workstatus'=>'workstatus_fid',
		'jobfield'=>'jobfield',
		'role'=>'role',
		'bankcardbnum'=>'bankcard_bnum',
		'city'=>'city',
		'area'=>'area',
		'birthyearnum'=>'birthyear_num',
		'male'=>'ismale'
            ]);
    }
}