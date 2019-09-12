<?php
/**
 * Created by PhpStorm.
 * User: terence
 * Date: 2019-09-04
 * Time: 18:39
 */

namespace app\api\controller\v1;


use app\exception\EmptyException;
use app\exception\ParamsException;
use app\api\model\Banner as BannerModel;
use app\api\validate\BannerValidate;


class Banner
{
    public function index() {
        $ruleParams = ( new BannerValidate() ) -> goCheck();
        $id = $ruleParams['id'];
        $banner = BannerModel::getBannerById($id);
        return success($banner);
    }
}