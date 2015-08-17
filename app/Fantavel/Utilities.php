<?php namespace App\Fantavel;


use Carbon\Carbon;


class Utilities {


    /**
     * @param bool $dataConsegna default: false
     * @param string $formatoDataConsegna default: 'd/m/Y H:i:s'
     * @param string $timezone default: Europe/Rome
     * @return bool
     */
    public static function canSubmitFormation($dataConsegna=false, $formatoDataConsegna='d/m/Y H:i:s', $timezone='Europe/Rome'){

        $now = Carbon::now()->timezone($timezone);
        $canSubmitFormation = false;

        if($dataConsegna):
            $limite = Carbon::createFromFormat($formatoDataConsegna,$dataConsegna,$timezone);

            if($now->lt($limite)):
                $canSubmitFormation = true;
            endif;
        endif;

        return $canSubmitFormation;

    }


}