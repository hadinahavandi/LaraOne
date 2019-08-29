<?php
/**
 * Created by PhpStorm.
 * User: Will
 * Date: 7/12/2019
 * Time: 3:43 PM
 */

namespace App\Classes\Sweet;


class SweetDBFile
{
    public static $GENERAL_DATA_TYPE_FILE = 1;
    public static $GENERAL_DATA_TYPE_IMAGE = 2;
    public static $GENERAL_DATA_TYPE_AUDIO = 3;
    private $GeneralDataType;
    private $ModuleName;
    private $EntityName;
    private $FieldName;
    private $RecordID;
    private $FileExtension;
    private $ValidMimeTypes;
    private $MaxFileSize;

    public function uploadFromRequest($InputFile)
    {
        $Path = "";
        if ($InputFile != null) {
            $InputFile->move($this->getFolderLocation(), $this->getFileName());
            $Path = $this->getFileLocation();
        }
        return $Path;
    }

    public function compressImage($quality, $maxWidth, $maxHeight, $destination = null)
    {
        $Path = $this->getFileLocation();
        if (file_exists($Path)) {
            if ($destination == null)
                $destination = $Path;
            $this->_compressImage($Path, $destination, $quality, $maxWidth, $maxHeight);
        }
        return $Path;
    }

    private function _compressImage($source, $destination, $quality, $maxWidth, $maxHeight)
    {

        $info = getimagesize($source);

        $width = $info[0];
        $height = $info[1];
        //echo $width . "%".$height;
        $widthScaleFactor = $maxWidth / $width;
        $heightScaleFactor = $maxHeight / $height;
        $newWidth = 0;
        $newHeight = 0;
        if ($widthScaleFactor < $heightScaleFactor) {
            if ($width > $maxWidth) {

                $newWidth = $maxWidth;
                $newHeight = $height * $widthScaleFactor;
            }
        } else {

            if ($height > $maxHeight) {
                $newHeight = $maxHeight;
                $newWidth = $width * $heightScaleFactor;
            }
        }

        $image = "";
        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);
        if ($newHeight > 0 && $newWidth > 0) {
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagejpeg($newImage, $destination, $quality);
        } else
            imagejpeg($image, $destination, $quality);


    }
    public function getFileLocation()
    {
        return $this->getFolderLocation() . '/' . $this->getFileName();
    }

    public function getFolderLocation()
    {
        return $this->_getFolderName() . '/' . $this->ModuleName . '/' . $this->EntityName;
    }

    public function getFileName()
    {
        return $this->FieldName . '-' . $this->RecordID . '.' . $this->FileExtension;
    }

    private function _getFolderName()
    {
        if ($this->GeneralDataType == SweetDBFile::$GENERAL_DATA_TYPE_IMAGE)
            return 'img';
        elseif ($this->GeneralDataType == SweetDBFile::$GENERAL_DATA_TYPE_AUDIO)
            return 'audio';
        return 'file';
    }

    /**
     * SweetDBFile constructor.
     * @param int $GeneralDataType
     * @param string $ModuleName
     * @param string $EntityName
     * @param string $FieldName
     * @param int $RecordID
     * @param string $FileExtension
     */
    public function __construct($GeneralDataType, $ModuleName, $EntityName, $FieldName, $RecordID, $FileExtension)
    {
        $this->GeneralDataType = $GeneralDataType;
        $this->ModuleName = $ModuleName;
        $this->EntityName = $EntityName;
        $this->FieldName = $FieldName;
        $this->RecordID = $RecordID;
        $this->FileExtension = $FileExtension;
    }


    /**
     * @return mixed
     */
    public function getMaxFileSize()
    {
        return $this->MaxFileSize;
    }

    /**
     * @param mixed $MaxFileSize
     */
    public function setMaxFileSize($MaxFileSize): void
    {
        $this->MaxFileSize = $MaxFileSize;
    }

    /**
     * @return mixed
     */
    public function getModuleName()
    {
        return $this->ModuleName;
    }

    /**
     * @param mixed $ModuleName
     */
    public function setModuleName($ModuleName): void
    {
        $this->ModuleName = $ModuleName;
    }


    /**
     * @return mixed
     */
    public function getValidMimeTypes()
    {
        return $this->ValidMimeTypes;
    }

    /**
     * @param mixed $ValidMimeTypes
     */
    public function setValidMimeTypes($ValidMimeTypes): void
    {
        $this->ValidMimeTypes = $ValidMimeTypes;
    }

    /**
     * @return int
     */
    public function getGeneralDataType()
    {
        return $this->GeneralDataType;
    }

    /**
     * @param int $GeneralDataType
     */
    public function setGeneralDataType($GeneralDataType): void
    {
        $this->GeneralDataType = $GeneralDataType;
    }

    /**
     * @return mixed
     */
    public function getEntityName()
    {
        return $this->EntityName;
    }

    /**
     * @param mixed $EntityName
     */
    public function setEntityName($EntityName): void
    {
        $this->EntityName = $EntityName;
    }

    /**
     * @return mixed
     */
    public function getFieldName()
    {
        return $this->FieldName;
    }

    /**
     * @param mixed $FieldName
     */
    public function setFieldName($FieldName): void
    {
        $this->FieldName = $FieldName;
    }

    /**
     * @return mixed
     */
    public function getRecordID()
    {
        return $this->RecordID;
    }

    /**
     * @param mixed $RecordID
     */
    public function setRecordID($RecordID): void
    {
        $this->RecordID = $RecordID;
    }

    /**
     * @return mixed
     */
    public function getFileExtension()
    {
        return $this->FileExtension;
    }

    /**
     * @param mixed $FileExtension
     */
    public function setFileExtension($FileExtension): void
    {
        $this->FileExtension = $FileExtension;
    }


}