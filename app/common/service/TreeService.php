<?php


namespace app\common\service;


class TreeService
{


    public static function MakeTree($list,$pk,$pid,$child='children',$root=0){
        $tree=[];

        foreach ($list as $k=>$v){

            if($v[$pid]==$root){


                $node=[
                    'id'=>$v[$pk],
                    'parentId'=>$v[$pid],
                    'name'=>$v['dept_name'],
                    'order_by'=>$v['order_by'],
                 ];
                unset($list[$k]);
                if(!empty($list)){
                    $child=self::MakeTree($list,$pk,$pid,$child,$v[$pk]);
                    if(!empty($child)){
                        $node['children']=$child;

                    }

                }
                $tree[]=$node;
            }
        }
        return $tree;
    }

    public static function MakeTreePids($list,$pk,$pid,$child='children',$root=0){
        $tree=[];

        foreach ($list as $k=>$v){

            if($v[$pid]==$root){


                $node=[
                    'id'=>$v[$pk],
                    'name'=>$v['dept_name'],


                ];
                unset($list[$k]);
                if(!empty($list)){
                    $child=self::MakeTreePid($list,$pk,$pid,$child,$v[$pk]);
                    if(!empty($child)){
                        $node['children']=$child;

                    }

                }
                $tree[]=$node;
            }
        }
        return $tree;
    }




    public static function MakeMenuTree($list,$pk,$pid,$child='children',$root=0){
        $tree=[];

        foreach ($list as $k=>$v){

            if($v[$pid]==$root){


                $node=[
                    'id'=>$v[$pk],
                    'parentId'=>$v[$pid],
                    'component'=>$v['component'],
                    'path'=>$v['path'],
                    'name'=>$v['menu_name'],
                    'perms'=>$v['perms'],
                    'icon'=>$v['icon'],
                    'status'=>$v['status'],
                    'visible'=>$v['visible'],
                    'order_by'=>$v['order_by'],
                    'type'=>$v['type'],

                ];
                unset($list[$k]);
                if(!empty($list)){
                    $child=self::MakeMenuTree($list,$pk,$pid,$child,$v[$pk]);
                    if(!empty($child)){
                        $node['children']=$child;

                    }

                }
                $tree[]=$node;
            }
        }
        return $tree;
    }



    public static function MakeTreePid($list,$pk,$pid,$child='children',$root=0){
        $tree=[];

        foreach ($list as $k=>$v){

            if($v[$pid]==$root){


                $node=[
                    'id'=>$v[$pk],
                    'name'=>$v['menu_name'],


                ];
                unset($list[$k]);
                if(!empty($list)){
                    $child=self::MakeTreePid($list,$pk,$pid,$child,$v[$pk]);
                    if(!empty($child)){
                        $node['children']=$child;

                    }

                }
                $tree[]=$node;
            }
        }
        return $tree;
    }

}