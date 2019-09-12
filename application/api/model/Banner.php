<?php
/**
 * Created by PhpStorm.
 * User: terence
 * Date: 2019-09-09
 * Time: 20:42
 */

namespace app\api\model;


class Banner extends BaseModel
{
    //TODO 定义模型关联
    public function items() {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    public static function getBannerById($id) {
        $banner = self::with('items') -> find($id);
        return $banner;
    }
}