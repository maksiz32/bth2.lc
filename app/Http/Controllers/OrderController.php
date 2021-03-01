<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Tech;
use App\Firm;
use App\Remain;
use App\Http\Requests\OrderRequest;
use Mail;
use Adldap\Laravel\Facades\Adldap;
use App\Facade\BryanskPortal;

class OrderController extends Controller
{

    public function __construct() {
        $this->middleware('isADAdmin')->except(['index', 'store', 'linkSubmit']);
    }
    
    public function index(Request $request) {
        $ip = $request->ip();
        $long_ip = ip2long($ip);
        $userRealName = BryanskPortal::getName(getenv('REMOTE_USER'));
        $firm = Firm::where('ipStart', '<=', $long_ip)->where('ipEnd', '>=', $long_ip)->first();
        return view('orders.main', ['ip' => $ip, 'firm' => $firm, 
            'userRealName' => $userRealName,
            'technics' => Tech::allTechnics(),
            'categories' => Tech::allCategories()]);
    }
    
    public function store(Request $request) {
        if ($result = Order::orderAction($request)) {
            $link = url(action('OrderController@linkSubmit', ['ip' => $result['ip'], 'dateO' => $result['date']]));
            $this->sendmail($result['data'], $result['userRealName'], $link);
            return view("orders.success", ['order' => $result['data']])->with("success", "Ваш заказ отправлен");
        }
            return redirect(action("OrderController@index"))->with("danger", 
                    "Нельзя отправить пустой заказ. Повторите заказ еще раз");
    }
    
    public function linkSubmit($ip, $dateO) {
            $res = Order::getSubOrderFromLink($ip, $dateO);
        return view('orders.submitorder', ['orders' => $res, 'nobutton' => false]);
    }
    
    public function linkSubmitAdmin() {
        $res = Order::getAllSubOrderFromLink();
        return view('orders.submitorder', ['orders' => $res, 'nobutton' => true]);
    }
    
    public function submitOrder(Request $request) {
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
        return redirect(action('OrderController@linkSubmitAdmin'))->with("susses", 
            "Данные были изменены");
    }

    protected function sendmail($order, $userRealName, $link) {
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
                'Для учета остатков обязательно подтвердить отгрузку: '.$link."\r\n"."\r\n".
                'Отправлено от '.$userRealName.
                $mes."\r\n"."\r\n"."\r\n".
                'Дополнительно:'.
                $mes2;
        Mail::raw($text, function($formail) use($title){
            $formail->from('report@bryansk.rgs.ru', "Заказ картриджей");
            $formail->to(['maksim_manzulin@bryansk.rgs.ru']);
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
