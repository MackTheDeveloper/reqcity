<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterLinks extends Model
{
    protected $table = 'footer_links';

    protected $fillable = ['fb_link','insta_link','youtube_link','twitter_link'];

    public static function getFooterData()
    {
        $dataFooter = self::selectRaw('name,type,relation_data')->where('deleted_at',null)->where('is_active','1')->orderBy('sort_order','asc')->limit(4)->get();

        $return = array();
        foreach($dataFooter as $k => $v)
        {
            if($v->type == 'cms')
            {
                $return[$k]['footerDetails']['footerName'] = $v->name;
                $return[$k]['footerDetails']['footerType'] = $v->type;
                $return[$k]['footerMenuData'] = CmsPages::getDataForFooter($v->relation_data);
            }else if($v->type == 'category')
            {
                $return[$k]['footerDetails']['footerName'] = $v->name;
                $return[$k]['footerDetails']['footerType'] = $v->type;
                $return[$k]['footerMenuData'] = Category::getDataForFooter($v->relation_data);
            }
        }
        return $return;
    }
}
