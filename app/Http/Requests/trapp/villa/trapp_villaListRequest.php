<?php
namespace App\Http\Requests\trapp\villa;
use App\Http\Requests\sweetRequest;

class trapp_villaListRequest extends trapp_villaRequest
{
    public function getOrderFields()
    {
        $this->getOrderFieldsFromList([
            'placemanplace'=>'placeman_place_fid',
            'viewtype'=>'viewtype_fid',
            'structuretype'=>'structuretype_fid',
            'owningtype'=>'owningtype_fid',
            'areatype'=>'areatype_fid',
        ]);
    }
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->setRequestMethod(sweetRequest::$REQUEST_METHOD_GET);
    }
}