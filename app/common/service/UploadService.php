<?php


namespace app\common\service;


use app\apiadmin\model\files\FilesSetModel;
use app\apiadmin\service\files\FilesService;

use app\common\utils\Res;

use think\facade\Filesystem;
use think\facade\Request;

class UploadService
{


    public static function uploads($file, $by)
    {
        $fileSet = FilesSetModel::findByid();
        if (empty($file)) {
            return Res::error("上传文件错误");
        }
        $extension = $file->getOriginalExtension();

        if (!in_array($extension, explode(',', $fileSet['allowExts']))) {
            return Res::error("上传文件失败，不允许上传的文件类型");
        }
        $size = $file->getSize();
        if ($size > $fileSet['fileSize']) {
            return Res::error('上传文件失败，文件超过上传限制');
        }
        $getSaveName = str_replace("\\", "/", $file->getOriginalName());
        $type = 3000;
        $img = "bmp,jpg,jpeg,png,tiff,gif,pcx,tga,exif,fpx,svg,psd,cdr,pcd,dxf,ufo,eps,ai,raw,wmf";
        if (strpos($img, $extension) != false) {
            $type = 0;
        }
        $txt = "txt,doc,docx,xls,htm,html,jsp,rtf,wpd,pdf,ppt";
        if (strpos($txt, $extension) != false) {
            $type = 1;
        }
        $video = "mp4,avi,mov,wmv,asf,navi,3gp,mkv,f4v,rmvb,webm";
        if (strpos($video, $extension) != false) {
            $type = 2;
        }
        //本地存储
        if ($fileSet['files_ares'] == 0) {

            return  UploadService::local($extension, $file, $type, $by, $size);
        }
        //七牛
        //阿里云
        //腾讯云
        //华为云
    }


    /**
     * @param $extension
     * @param $file
     * 本地存储
     */
    public static  function local($extension, $file, $type, $by, $size)
    {
        $fileName = Filesystem::disk('public')->putFile($extension, $file, 'uniqid');
        $sname = str_replace("\\", "/", $fileName);
        $getSaveName = str_replace("\\", "/", $file->getOriginalName());
        $data = [
            'name' => $getSaveName,
            'f_type' => $extension,
            'type' => $type,
            'urls' => '/storage/' . $fileName,
            'creat_time' => date('Y-m-d H:i:s', time()),
            'creat_by' => $by,
            'http_urls' => Request::domain() . '/storage/' . $fileName,
            'oss' => '本地',
            'f_size' => $size,
        ];
        $result = FilesService::add($data);
        return $result;
    }
}
