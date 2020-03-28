<?php
namespace App\Http\Requests\trapp\villa;
use App\Http\Requests\sweetRequest;

class trapp_villaRequest extends sweetRequest
{
    public function rules()
    {
        return ["id"=>'max:1024'];
    }

    public function authorize()
    {
        return true;
    }
    public function getRoomcountnum(){return $this->getNumberField('roomcountnum');}
    public function getCapacitynum(){return $this->getNumberField('capacitynum');}
    public function getMaxguestsnum(){return $this->getNumberField('maxguestsnum');}
    public function getStructureareanum(){return $this->getNumberField('structureareanum');}
    public function getTotalareanum(){return $this->getNumberField('totalareanum');}
    public function getPlacemanplace(){return $this->getNumberField('placemanplace',-1);}
    public function getAddedbyowner(){return $this->getField('addedbyowner',' ');}
    public function getViewtype(){return $this->getNumberField('viewtype',-1);}
    public function getStructuretype(){return $this->getNumberField('structuretype',-1);}
    public function getFulltimeservice(){return $this->getField('fulltimeservice',' ');}
    public function getTimestartclk(){return $this->getField('timestartclk',' ');}
    public function getOwningtype(){return $this->getNumberField('owningtype',-1);}
    public function getAreatype(){return $this->getNumberField('areatype',-1);}
    public function getDescriptionte(){return $this->getField('descriptionte',' ');}
    public function getNormalpriceprc(){return $this->getNumberField('normalpriceprc');}
    public function getHolidaypriceprc(){return $this->getNumberField('holidaypriceprc');}
    public function getWeeklyoffnum(){return $this->getNumberField('weeklyoffnum');}
    public function getMonthlyoffnum(){return $this->getNumberField('monthlyoffnum');}
    public function getDocumentphotoiguPath(){return $this->getFileField('documentphotoigu');}
    public function getDiscountnum(){return $this->getNumberField('discountnum');}
}