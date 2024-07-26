<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function getPrice() {
        return self::_getSetting("card_price", 10);
    }

    public static function setPrice($price) {
        self::_setSetting("card_price", $price);
    }

    public static function getMinimumPurchaseQuantity() {
        return self::_getSetting("minimum_purchase_quantity", 5);
    }

    public static function setMinimumPurchaseQuantity($value) {
        self::_setSetting("minimum_purchase_quantity", $value);
    }

    public static function isEnabledSelling() {
        $maintenanceMode = self::_getSetting("maintenance_mode", "no");
        return $maintenanceMode == "no";
    }

    public static function setEnableSelling($enabled) {
        $maintenanceValue = $enabled ? "no" : "yes";
        self::_setSetting("maintenance_mode", $maintenanceValue);
    }

    public static function getStartSelling() {
        return self::_getSetting("start_selling", 1);
    }

    public static function setStartSelling($value) {
        self::_setSetting("start_selling", $value);
    }

    public static function getEndSelling() {
        return self::_getSetting("end_selling", 10000000);
    }

    public static function setEndSelling($value) {
        self::_setSetting("end_selling", $value);
    }

    public static function _getSetting($setting, $default) {
        $settingObject = self::where('setting', $setting)->first();
        if (empty($settingObject)) {
            return $default;
        }

        return $settingObject->value;
    }

    public static function _setSetting($setting, $value) {
        $settingObject = self::where('setting', $setting)->first();
        if (empty($settingObject)) {
            self::create([
                'setting' => $setting,
                'value' => $value
            ]);
        } else {
            $settingObject->value = $value;
            $settingObject->save();
        }
    }
}
