<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Remain;
use App\Firm;

class Order extends Model
{
    protected $fillable = ['firm','user_name','ad_name','real_ip','created','tech','model','count_m','others'];
    protected $primaryKey = "id";
    
    public static function orderAction($request) {
        $order = $request->all();
        $firm = $request->firm;
        $other = $order['others'];
        $created = date('Y-m-d H:i:s');
        $real_ip = ip2long($order['real_ip']);
        $res['userRealName'] = $order['userRealName'];
        $res['ad_name'] = getenv('REMOTE_USER');
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
                    'ad_name' => getenv('REMOTE_USER'),
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
                    'ad_name' => getenv('REMOTE_USER'),
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
                'remains.id as id', 'orders.id as order_id', 'orders.firm', 'orders.created', 
                'orders.user_name','orders.ad_name', 'orders.real_ip', 'orders.tech', 'orders.confirmed', 
                'orders.model', 'orders.count_m', 'remains.tech_id', 
                'remains.count')->where('real_ip', '=', $ip)->where('created', '=', $dateO)->
                join('teches', 'orders.model', '=', 'teches.model')->
                join('remains', 'teches.id', '=', 'remains.tech_id')->
                orderBy('order_id')->paginate(1000);
        return $res;
    }
    
    public static function getAllSubOrderFromLink() {
        $res = Order::select(
                'remains.id as id', 'orders.id as order_id', 'orders.firm', 'orders.created',  
                'orders.user_name','orders.ad_name', 'orders.real_ip', 'orders.tech', 'orders.confirmed', 
                'orders.model', 'orders.count_m', 'remains.tech_id', 
                'remains.count')->
                join('teches', 'orders.model', '=', 'teches.model')->
                join('remains', 'teches.id', '=', 'remains.tech_id')->
                orderBy('order_id', 'desc')->paginate(30);
        return $res;
    }
    
    public static function submitOrderAdmin($request) {
        $confirmed = 1;
        //В orders.db подтвердить confirmed и изменить count_м.
        for ($i=0; $i<count($request->ordId); $i++) {
            $data = Order::where('id', $request->ordId[$i])->first();
            if ($data) {
                $data->confirmed = $confirmed;
                $data->count_m = $request->count[$i];
                $data->save();
            }
        //В remains отминусовать count
            $data2 = Remain::where('id', $request->remainId[$i])->first();
            if ($data2) {
                $data2->count = $data2->count - $request->count[$i];
                $data2->save();
            }
        }
        $text = Order::makeMailBody($request);
        $res['title'] = $text['title'];
        $res['text'] = $text['text'];
        $res['ad_name'] = $request->adName;
        return $res;
    }
    
    public static function makeMailBody($request) {
        $firm = Firm::select('name')->where('ipStart', '<=', $request->ip)->
                where('ipEnd', '>=', $request->ip)->first();
        $firm = json_decode($firm)->name;
        $mes = "\r\n"."\r\n";
        $mes2 = "\r\n"."\r\n";
        $order = Order::getSubOrderFromLink($request->ip, $request->dateO);
        if(isset($order[0]['id'])) {
            foreach($order as $ord) {
                $mes .= ' - Картридж '.$ord['model'].' в количестве - '.$ord['count_m'].' шт.'."\r\n"."\r\n";
                $mes2 .= $ord['others']."\r\n"."\r\n";
            }
        } else {
            $mes2 .= $order[0]['others']."\r\n"."\r\n";
        }
        $title = "Подтверждение заказа для {$firm}";
        $text = "Заказ картриджей для {$firm} подтвержден в количестве:\r\n"."\r\n".
                $mes."\r\n"."\r\n"."\r\n".
                "Дополнительно: {$mes2}";
        $res['title'] = $title;
        $res['text'] = $text;
        return $res;
    }
}
