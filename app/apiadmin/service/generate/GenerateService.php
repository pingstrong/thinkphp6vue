<?php


namespace app\apiadmin\service\generate;

use app\apiadmin\model\generate\GenerateListModel;
use app\apiadmin\model\generate\GenerateModel;
use app\common\utils\Res;
use think\facade\Db;
use think\facade\Env;
use think\facade\Config;
class GenerateService
{


    /**
     * @param $table
     * @return \think\response\Json
     * 查询生成配置
     */
    public static function findGen($table){
        $result = GenerateModel::findByTabels($table);
        $tables = substr($table,strripos($table,"_")+1);
        $datas=[];
        if(empty($result)){
            $result=[
                'tables'=>$table,
                'type'=>0,
                'models'=>ucfirst($tables),
                'gid'=>0
            ];
            $tableList = GenerateService::columns($table);
            foreach ($tableList as $k=>$v){
                $datas[]=[
                    'name'=>$v['Field'],
                    'remks'=>$v['Comment'],
                    'is_add'=>0,
                    'is_edit'=>0,
                    'is_list'=>0,
                    'is_view'=>0,
                    'is_val'=>0,
                    'is_type'=>$v['Type']
                ];
            }

        }else{
            $datas = GenerateListModel::findByGid($result['gid']);
        }
        $data=['geninfo'=>$result,'genlist'=>$datas];
        return Res::ok($data);
    }



    public static function add($param){
        try {
          if($param['gid']==0){
              //如果有值
              $result = GenerateModel::add($param);
          }else{
              $result = $param['gid'];
              GenerateModel::edit($param);
              GenerateListModel::del($param['gid']);

          }
          foreach ($param['list'] as $k=>$v){
              //$param['list'][$k]['gid']=$result;
              $v['gid']=$result;
              GenerateListModel::add($v);
          }
          return  Res::ok($result);


        }catch (\PDOException $e){
            return Res::error($e->getMessage());
        }
    }




    /**
     * @return array
     * 获取数据库所有表
     */
    public static  function tables(){
        $tables = Db::query('SHOW  TABLES');
        $tbs = array();
        foreach ($tables as $t){
            $tbs[] = $t["Tables_in_".env('database.database', '')];
        }
        return $tbs;
    }



    /**
     * @param $table 表名称
     * @return array 返回表的字段
     */
    public static function columns($table){
        $columns = Db::query("SHOW FULL COLUMNS FROM ".$table);

        return $columns;
    }

    public static function columnId($table){
        $columns = Db::query("SHOW FULL COLUMNS FROM ".$table);
        foreach ($columns as $c){
            if($c['Key']=='PRI'){
                $key = $c['Field'];
            }
        }
        return $key;
    }

    public static function genReady($param){
     //准备工作
        //接收过来的数据,获取此表的主键
        $cls = self::columnId($param['formdata']['tables']);


        $readyBuild=[
            'names'=>$param['names'],
            'name'=>$param['name'],
            'id'=>$cls,
            'tables'=>$param['tables'],
            'type'=>$param['type']
         ];
        return $readyBuild;
    }

    public static function genModel($param){
       $type = $param['type'];
        switch ($type){
            case 1:
                $url =root_path().Config::get('generate.list_model_url');
                break;
            case 2:
                $url =root_path().Config::get('generate.tree_model_url');
                break;
        }
        $gengrateFiles = file_get_contents($url);
        $acpFiles=  str_replace(['{names}','{name}', '{table}','{id}'], [$param['names'],$param['name'],$param['tables'],$param['id']], $gengrateFiles);
        return $acpFiles;

    }

    public static function genController($param){
        $type = $param['type'];
        switch ($type){
            case 1:
                $url =root_path().Config::get('generate.list_controller_url');
                break;
            case 2:
                $url =root_path().Config::get('generate.tree_controller_url');
                break;
        }
        $gengrateFiles = file_get_contents($url);
        $acpFiles=  str_replace(['{names}','{name}'], [$param['names'],$param['name']], $gengrateFiles);
        return $acpFiles;
    }

    public static function genService($param){
        $type = $param['type'];
        switch ($type){
            case 1:
                $url =root_path().Config::get('generate.list_service_url');
                break;
            case 2:
                $url =root_path().Config::get('generate.list_service_url');
                break;
        }
        $gengrateFiles = file_get_contents($url);
        $acpFiles=  str_replace(['{names}','{name}'], [$param['names'],$param['name']], $gengrateFiles);
        return $acpFiles;
    }





}