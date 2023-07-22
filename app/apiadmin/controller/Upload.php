<?php


namespace app\apiadmin\controller;


use app\common\controller\BaseController;
use app\common\service\UploadService;

class Upload extends BaseController
{


   public function uploads(){
       $files = $this->request->file('file');
       $by=$this->request->userName;
       $result = UploadService::uploads($files,$by);
       return $result;
   }

}