<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['firm','user_name','real_ip','created','tech','model','count_m','others'];
    protected $primaryKey = "id";
    
    public static function orderAction($request) {
        $order = $request->all();
        $firm = $request->firm;
        $other = $order['others'];
        $created = date('Y-m-d H:i:s');
        $real_ip = ip2long($order['real_ip']);
        $res['userRealName'] = $order['userRealName'];
        if (isset($order['model'])) {
            for($i=0; $i < count($order['model']); $i++) {
                    if(!$i) {
                        $other = $order['others'];
                    } else {
                        $other = null;
                    }
                $data1[] = [
                    'tech' => $order['tech'][$i],
                    'model' => $order['model'][$i],
                    'count_m' => $order['count_m'][$i],
                    'firm' => $firm,
                    'user_name' => $order['userRealName'],
                    'real_ip' => $real_ip,
                    'created' => $created,
                    'others' => $other,
                ];
            }
            $order1 = Order::insert($data1);
            $res['data'] = $data1;
        } else if ($order['others'] != null) {
            $data1[] = [
                'firm' => $firm,
                'user_name' => $order['userRealName'],
                'real_ip' => $real_ip,
                'created' => $created,
                'others' => $other,
            ];
            $order1 = Order::insert($data1);
            $res['data'] = $data1;
        }
            $res['ip'] = $real_ip;
            $res['date'] = $created;
        return $res;
    }
    
    public static function getSubOrderFromLink($ip, $dateO) {
        $res = Order::select(
                'remains.id as id', 'orders.id as order_id', 'orders.firm', 
                'orders.user_name', 'orders.real_ip', 'orders.tech', 'orders.confirmed', 
                'orders.model', 'orders.count_m', 'remains.tech_id', 
                'remains.count')->where('real_ip', '=', $ip)->where('created', '=', $dateO)->
                join('teches', 'orders.model', '=', 'teches.model')->
                join('remains', 'teches.id', '=', 'remains.tech_id')->
                orderBy('order_id')->paginate(1000);
        return $res;
    }
    
    public static function getAllSubOrderFromLink() {
        $res = Order::select(
                'remains.id as id', 'orders.id as order_id', 'orders.firm', 
                'orders.user_name', 'orders.real_ip', 'orders.tech', 'orders.confirmed', 
                'orders.model', 'orders.count_m', 'remains.tech_id', 
                'remains.count')->
                join('teches', 'orders.model', '=', 'teches.model')->
                join('remains', 'teches.id', '=', 'remains.tech_id')->
                orderBy('order_id', 'desc')->paginate(30);
        return $res;
    }
}
