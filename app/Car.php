<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    public function getWeekDay($dateIn) {
        $week = [
            1 => 'пн',
            2 => 'вт',
            3 => 'ср',
            4 => 'чт',
            5 => 'пт',
            6 => 'сб',
            7 => 'вс',
        ];
        $dateIn = explode('-', $dateIn);
        $dateIn = $week[date('N', mktime(0,0,0,$dateIn[1],$dateIn[0],$dateIn[2]))];
        return $dateIn;
    }
    
    public function getWeekDayNum($dateIn) {
        $dateIn = explode('-', $dateIn);
        $dateIn = date('N', mktime(0,0,0,$dateIn[1],'1',$dateIn[2]));
        return $dateIn;
    }
    
    public function countDaysInMounth($dateIn) {
        $dateIn = explode('-', $dateIn);
        $dateIn = date('t', mktime(0,0,0,$dateIn[1],$dateIn[0],$dateIn[2]));
        return $dateIn;
    }
    public function getNameMounth($dateIn){
        //dd($dateIn);
        $dateIn = explode('-', $dateIn);
        (strlen($dateIn[1])<2)?$dateIn[1]='0'.$dateIn[1]:true;
        $rMth = [
        "01" => "Январь",
        "02" => "Февраль",
        "03" => "Март",
        "04" => "Апрель",
        "05" => "Май",
        "06" => "Июнь",
        "07" => "Июль",
        "08" => "Август",
        "09" => "Сентябрь",
        "10" => "Октябрь",
        "11" => "Ноябрь",
        "12" => "Декабрь",
    ];
    return $rMth[$dateIn[1]];
    }
    
    public function mounthP($data) {
    $data = explode("-", $data);
    $mounth = $data[1];
    $rMth = [
        "01" => " января ",
        "02" => " февраля ",
        "03" => " марта ",
        "04" => " апреля ",
        "05" => " мая ",
        "06" => " июня ",
        "07" => " июля ",
        "08" => " августа ",
        "09" => " сентября ",
        "10" => " октября ",
        "11" => " ноября ",
        "12" => " декабря ",
    ];
    (isset($data[2]))?$result = $data[0].$rMth[$mounth].$data[2]." г.":$result = $data[0].$rMth[$mounth];
    return $result;
    }
    
    public function mounthNameP($data) {
    $data = explode("-", $data);
    $mounth = $data[1];
    $rMth = [
        "01" => " января ",
        "02" => " февраля ",
        "03" => " марта ",
        "04" => " апреля ",
        "05" => " мая ",
        "06" => " июня ",
        "07" => " июля ",
        "08" => " августа ",
        "09" => " сентября ",
        "10" => " октября ",
        "11" => " ноября ",
        "12" => " декабря ",
    ];
    return $rMth[$mounth];
    }
    
    public function getPrewMounthName($dateIn){
        $dateIn = explode('-', $dateIn);
        //dd(strlen($dateIn[1]));
        if($dateIn[1] > 1) {
            $year = $dateIn[2];
            $dateI = $this->getNameMounth($dateIn[0].'-'.($dateIn[1]-1).'-'.$dateIn[2]);
        } else {
            $year = ($dateIn[2]-1);
            $dateI = $this->getNameMounth($dateIn[0].'-12-'.($dateIn[2]-1));
        }
        return $dateI." ".$year." г.";
    }
    
    public function getNextMounthName($dateIn){
        $dateIn = explode('-', $dateIn);
        if($dateIn[1] < 12) {
            $year = $dateIn[2];
            $dateI = $this->getNameMounth($dateIn[0].'-'.($dateIn[1]+1).'-'.$dateIn[2]);
        } else {
            $year = ($dateIn[2]+1);
            $dateI = $this->getNameMounth($dateIn[0].'-01-'.($dateIn[2]+1));
        }
        return $dateI." ".$year." г.";
    }
    public function setNextMounth($dateIn) {
        $dateIn = explode('-', $dateIn);
        if($dateIn[1] < 12) {
            (strlen($dateIn[1])<2)?$dateIn[1]='0'.$dateIn[1]:true;
            $dateI = '15-'.($dateIn[1]+1).'-'.$dateIn[2];
        } else {
            (strlen($dateIn[1])<2)?$dateIn[1]='0'.$dateIn[1]:true;
            $dateI = '15-01-'.($dateIn[2]+1);
        }
        return $dateI;
    }
    public function setPrewMounth($dateIn) {
        $dateIn = explode('-', $dateIn);
        if($dateIn[1] > 1) {
        (strlen($dateIn[1])<2)?$dateIn[1]='0'.$dateIn[1]:true;
        $dateI = '15-'.($dateIn[1]-1).'-'.$dateIn[2];
        } else {
            (strlen($dateIn[1])<2)?$dateIn[1]='0'.$dateIn[1]:true;
            $dateI = '15-12-'.($dateIn[2]-1);
        }
        return $dateI;
    }
    public static function setTimeStart($time) {
        $t = [
            1 => '09:00',
            2 => '10:00',
            3 => '11:00',
            4 => '12:00',
            5 => '14:00',
            6 => '15:00',
            7 => '16:00',
            8 => '17:00',
            9 => '18:00',
            ];
        return $t[$time];
    }
}
