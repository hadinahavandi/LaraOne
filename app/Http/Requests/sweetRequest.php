<?php
/**
 * Created by PhpStorm.
 * User: Will
 * Date: 8/12/2019
 * Time: 2:15 PM
 */

namespace App\Http\Requests;

use App\Http\Controllers\common\classes\SweetDateManager;
use Illuminate\Foundation\Http\FormRequest;

class sweetRequest extends FormRequest
{
    protected static $REQUEST_METHOD_POST=1;
    protected static $REQUEST_METHOD_PUT=2;
    protected static $REQUEST_METHOD_GET=3;
    protected static $REQUEST_METHOD_UNDEFINED=0;
    private $requestMethod;

    /**
     * @param int $requestMethod
     */
    protected function setRequestMethod(int $requestMethod): void
    {
        $this->requestMethod = $requestMethod;
    }
    private $_isUpdate = false;

    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->setRequestMethod(sweetRequest::$REQUEST_METHOD_UNDEFINED);
    }

    /**
     * @return bool
     */
    public function isUpdate(): bool
    {
        return $this->_isUpdate;
    }

    /**
     * @param bool $isUpdate
     */
    public function setIsUpdate(bool $isUpdate): void
    {
        $this->_isUpdate = $isUpdate;
    }

    protected function getField($fieldName,$defaultValue){
        if($this->requestMethod==sweetRequest::$REQUEST_METHOD_POST)
            return $this->input($fieldName,$defaultValue);
        return $this->get($fieldName,$defaultValue);
    }
    protected function getFileField($fieldName){
        return $this->file($fieldName);
    }
    protected function getTimestampFromStringField($fieldName){
        return SweetDateManager::getTimeStampFromString($this->getField($fieldName,' '));
    }
    protected function getNumberField($fieldName,$defaultValue=0){
        return $this->getField($fieldName,$defaultValue);
    }
    protected function getFieldSortState($FieldName)
    {
        $FieldName=trim($FieldName);
        $SortFieldName=$FieldName."__sort";
        $FieldValue=$this->get($SortFieldName);
        if($FieldValue!=null){
            $normalValue=strtolower(trim($FieldValue));
            if($normalValue==0)
                return 0;
            if($normalValue==1)
                return 1;
        }
        return null;
    }

    protected function getOrderFieldsFromList($FieldsList)
    {
        $orderFields=[];
        $keys=array_keys($FieldsList);
        for($i=0;$i<count($keys);$i++)
        {
//            $keys=array_keys($item);
//            if($keys!=null && count($keys)>0) {
                $requestFieldName = $keys[$i];
                $dbFieldName = $FieldsList[$requestFieldName];;
                if ($this->getFieldSortState($requestFieldName) != null)
                    array_push($orderFields, [$dbFieldName => $this->getFieldSortState($requestFieldName)]);
//            }

        }
        return $orderFields;
    }
    public function isOnlyCount()
    {
        if($this->get('_onlycount')!==null)
            return true;
        return false;
    }
    public function getStartRow()
    {
        return $this->get('__startrow');
    }
    public function getPageSize()
    {
        return $this->get('__pagesize');
    }
    public function rules()
    {
        return ["id"=>'max:1024'];
    }
    public function authorize()
    {
        return true;
    }

}