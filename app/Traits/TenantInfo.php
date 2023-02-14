<?php
namespace App\Traits;

trait TenantInfo {

	public function getTenantId()
    {
        $url = \URL::to('/');
        if(strpos($url, "https://") !== false)
            $url = str_replace("https://", "", $url);
        elseif(strpos($url, "http://") !== false)
            $url = str_replace("http://", "", $url);
        $urlInfo = explode(".", $url);
        return $urlInfo[0];
    }
}