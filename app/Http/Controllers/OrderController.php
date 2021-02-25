<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Tech;
use App\Firm;
use App\Http\Requests\OrderRequest;
use Mail;
use Adldap\Laravel\Facades\Adldap;
use App\Facade\BryanskPortal;

class OrderController extends Controller
{
    public function index(Request $request) {
        $ip = $request->ip();
        $long_ip = ip2long($ip);
        $userRealName = BryanskPortal::getName(getenv('REMOTE_USER'));
        $firm = Firm::where('ipStart', '<=', $long_ip)->where('ipEnd', '>=', $long_ip)->first();
        return view('orders.main', ['ip' => $ip, 'firm' => $firm, 
            'userRealName' => $userRealName,
            'prints' => Tech::where('category',1)->orderBy('id', 'DESC')->get(), 
            'copyrs' => Tech::where('category',2)->orderBy('id', 'DESC')->get(), 
            'mfus' => Tech::where('category',3)->orderBy('id', 'DESC')->get(), 
            'picsP' => Tech::where('category',1)->orderBy('id', 'DESC')->take(4)->get(), 
            'picsC' => Tech::where('category',2)->orderBy('id', 'DESC')->take(4)->get(), 
            'picsM' => Tech::where('category',3)->orderBy('id', 'DESC')->take(4)->get()]);
    }
    
    public function store(Request $request) {
        $order = $request->all();
        $firm = $request->firm;
        $other = $order['others'];
        $userRealName = $order['userRealName'];
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
                'real_ip' => ip2long($order['real_ip']),
                'created' => $order['created'],
                'others' => $other,
            ];
        }
        $order1 = Order::insert($data1);
        $this->sendmail($data1, $userRealName);
            return view("orders.success", ['order' => $data1])->with("success", "Ваш заказ отправлен");
        } else if ($order['others'] != null) {
            $data1[] = [
                'firm' => $firm,
                'real_ip' => ip2long($order['real_ip']),
                'created' => $order['created'],
                'others' => $other,
            ];
        $order1 = Order::insert($data1);
        $this->sendmail($data1, $userRealName);
            return view("orders.success", ['order' => $data1])->with("success", "Ваш заказ отправлен");
        }
            return redirect(action("OrderController@index"))->with("danger", 
                    "Нельзя отправить пустой заказ. Повторите заказ еще раз");
    }
    
    protected function sendmail($order, $userRealName) {
        $firm = $order[0]['firm'];
        /*
        //Здесь отправка html
        Mail::send('emails.order', ['order' => $order, 'userRealName' => $userRealName], function($message) use ($firm) {
                $message->from('report@bryansk.rgs.ru', 'Order');
                $message->to(['maksim_manzulin@bryansk.rgs.ru','vladislav_spinskiy@bryansk.rgs.ru','help@bryansk.rgs.ru']);
                $message->subject('Заказ картриджей от '.$firm);
            });
            return $ok = 'OK';
         * 
         */
        $mes = "\r\n"."\r\n";
        $mes2 = "\r\n"."\r\n";
        if(isset($order[0]['model'])) {
            foreach($order as $ord) {
                $mes .= ' - Картридж '.$ord['model'].' для '.$ord['tech'].' в количестве - '.$ord['count_m'].' шт.'."\r\n"."\r\n";
                $mes2 .= $ord['others']."\r\n"."\r\n";
            }
        } else {
            $mes2 .= $order[0]['others']."\r\n"."\r\n";
        }
        $title = 'Заказ картриджей от '.$firm;
        //Отправляю просто текст
        $text = $title."\r\n"."\r\n"."\r\n".
                'Заказ картриджей от '.$firm.' с адреса '.long2ip($order[0]['real_ip']).':'."\r\n"."\r\n".
                'Отправлено от '.$userRealName.
                $mes."\r\n"."\r\n"."\r\n".
                'Дополнительно:'.
                $mes2;
        Mail::raw($text, function($formail) use($title){
            $formail->from('report@bryansk.rgs.ru', "Заказ картриджей");
            $formail->to(['maksim_manzulin@bryansk.rgs.ru','vladislav_spinskiy@bryansk.rgs.ru']);
            $formail->subject($title);
        });
        return true;
    }
    
    public function viewRep() {
        return view('orders.allrep');
    }
    
    public function byFirm() {
        return view('orders.byfirm',['firms' => Firm::select('name')->where('isblock', 1)->get()]);
    }
    
    public function byDate() {
        return view('orders.bydate');
    }
    
    public function byTech() {
        return view('orders.bytech',['teches' => Tech::all('model', 'tech')]);
    }
    
    public function getByFirm(Request $request, $what) {
        //setlocale(LC_TIME, 'ru_RU');
        if ($what === 'f') {
        return view('orders.reptab',['name' => $request->name, 
            'data' => Order::where('firm', $request->name)->orderBy('created', 'DESC')->get()]);
        } elseif ($what === 't') {
            return view('orders.reptab',['name' => $request->tech, 
            'data' => Order::where('model', $request->tech)->orderBy('created', 'DESC')->get()]);
        } elseif ($what === 'd') {
            $dateStart = date('Y-m-d', strtotime($request->dateStart));
            $dateEnd = date('Y-m-d', strtotime($request->dateEnd));
            return view('orders.reptab',['name' => "За период с " . strftime("%d %B %Y года", strtotime($request->dateStart)) . " по " . $request->dateEnd, 
            'data' => Order::whereBetween('created', [$dateStart, $dateEnd])->get()]);
        } else {
            return back();
        }
    }
}
