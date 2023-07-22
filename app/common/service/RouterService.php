<?php


namespace app\common\service;


class RouterService
{

    public static function MakeRouter($list,$child='children',$root=0){
        $tree=[];

        foreach ($list as $k=>$v){
            $hidden = true;
            if($v['visible']==0){
                $hidden = false;
            }
            $component = 'Layout';
            if($v['parent_id']!=0){
                $component = $v['component'];
            }
            $path = $v['path'];
            if($v['parent_id']==0){
                $path='/'.$v['path'];
            }
            if($v['parent_id']==$root){
                $node=[
                    'name'=>ucfirst($v['path']),
                    'path'=>$path,
                    'hidden'=>$hidden,
                    'component'=>$component,
                    'meta'=>[
                        'icon'=>$v['icon'],
                        'title'=>$v["menu_name"]
                    ]

                ];
                unset($list[$k]);
                if(!empty($list)){
                    $child=self::MakeRouter($list,$child,$v['menu_id']);
                    if(!empty($child)){
                        $node['alwaysShow']=true;
                        $node['children']=$child;
                        $node['redirect']='noRedirect';
                    }

                }

                $tree[]=$node;

            }

        }
        return $tree;
    }


}