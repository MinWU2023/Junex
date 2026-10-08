<?php


namespace App\Services;


use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

class GeoLiteService
{
    public function getLocationByIp($ip)
    {
        $path = storage_path('GeoLite2-City.mmdb');
        $reader = new Reader($path);
        $temp = [];
        try {
            $record = $reader->city($ip);
            if ($record->city->name) $temp[] = $record->city->name;
            if ($record->mostSpecificSubdivision->name) $temp[] = $record->mostSpecificSubdivision->name;
            if (isset($record->country->names['zh-CN'])) $temp[] = $record->country->names['zh-CN'];
        }catch (AddressNotFoundException $exception) {
            $temp[] = '未知区域';
        }

        return implode(',', $temp);
    }


    public function getCountry($ip){
        $path = storage_path('GeoLite2-City.mmdb');
        $reader = new Reader($path);
        try {
            $record = $reader->city($ip);
            if ($record->country->names['zh-CN']){
                return $record->country->names['zh-CN'];
            }
        }catch (AddressNotFoundException $exception) {

        } catch (\Exception $exception) {

        }
        return  "未知区域";
    }


}
