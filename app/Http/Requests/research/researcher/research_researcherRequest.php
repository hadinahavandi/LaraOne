<?php
namespace App\Http\Requests\research\researcher;
use App\Http\Requests\sweetRequest;

class research_researcherRequest extends sweetRequest
{
		public function getUser(){return $this->getNumberField('user',-1);}
		public function getName(){return $this->getField('name',' ');}
		public function getFamily(){return $this->getField('family',' ');}
		public function getUniversity(){return $this->getField('university',' ');}
		public function getStudyfield(){return $this->getField('studyfield',' ');}
		public function getInterestarea(){return $this->getField('interestarea',' ');}
		public function getTelnum(){return $this->getNumberField('telnum');}
		public function getMobnum(){return $this->getNumberField('mobnum');}
		public function getEmail(){return $this->getField('email',' ');}
		public function getUniversityGrade(){return $this->getNumberField('universitygrade',-1);}
		public function getWorkstatus(){return $this->getNumberField('workstatus',-1);}
		public function getJobfield(){return $this->getField('jobfield',' ');}
		public function getRole(){return $this->getField('role',' ');}
		public function getBankcardbnum(){return $this->getNumberField('bankcardbnum');}
		public function getCity(){return $this->getField('city',' ');}
		public function getArea(){return $this->getField('area',' ');}
		public function getBirthyearnum(){return $this->getNumberField('birthyearnum');}
		public function getMale(){return $this->getField('male',' ');}
		public function getLicenceiguPath(){return $this->getFileField('licenceigu');}
		public function getPassword(){return $this->getFileField('password');}
}