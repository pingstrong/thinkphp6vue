<?php


namespace app\apiadmin\service\files;


use app\apiadmin\model\files\FilesSetModel;
use app\common\utils\Res;

class FilesSetService
{

      public static function addEdit($param){
          try {
              $result = FilesSetModel::findByid();
              if($result){
                  FilesSetModel::edit($param);
              }else{
                  FilesSetModel::add($param);
              }
              return  Res::ok();

          }catch (\PDOException $e){
              return Res::error($e->getMessage());
          }
      }



}