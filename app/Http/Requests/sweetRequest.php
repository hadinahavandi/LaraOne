<?php
/**
 * Created by PhpStorm.
 * User: Will
 * Date: 8/12/2019
 * Time: 2:15 PM
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class sweetRequest extends FormRequest
{
    private $_isUpdate = false;

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

}