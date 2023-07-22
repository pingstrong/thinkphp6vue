<?php


namespace app\common\controller;


use think\App;
use think\exception\HttpResponseException;
use think\facade\View;
use think\Validate;

class BaseController
{

    protected $request;

    protected $app;

    protected $batchValidate = false;

    protected $middleware = [];

    public function __construct(App $app){
        $this->app     = $app;
        $this->request = app('request');
        $this->initialize();
    }

    protected function initialize()
    {

    }


    protected function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                [$validate, $scene] = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
            $v     = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        return $v->failException(true)->check($data);
    }

    protected function assign(...$arr){
        View::assign(...$arr);
    }


    protected function redirect(...$args){
        throw new HttpResponseException(redirect(...$args));
    }


}