<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AvtoRequest;
use App\Car;
use App\Avto;
use App\Booking;
use App\Birthday;
use Mail;
use App\BryanskPortal;
use App\NewMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class CarController extends Controller {

    public function __construct() {
        $this->middleware('isADAdmin')->except(['main', 'inputBook', 'saveBook',
            'sendEmail', 'allByMounth', 'delete']);
    }

    public function main(Car $car, $dateMain = null) {
        $arrDay = array();
        if ($dateMain == null) {
            $dateMain = date('d-m-Y');
        } else {
            $dateMain = date('d-m-Y', strtotime($dateMain));
        }
        $forBook = explode('-', $dateMain);
        $forBook = '01-' . $forBook[1] . '-' . $forBook[2];
        $forBook = [
            'm' => date('m', strtotime($forBook)),
            'y' => date('Y', strtotime($forBook))
        ];
        $bookings = Booking::selectAllDataByMounthAndDay($forBook);
        foreach ($bookings as $book) {
            $day = explode('-', $book->date);
            $arrDay[] = $day[2];
        }
        $countDays = $car->countDaysInMounth($dateMain);
        $numFirstDay = $car->getWeekDayNum($dateMain);
        return view('car.main', ['car' => $car, 'countDays' => $countDays,
            'numFirstDay' => $numFirstDay, 'dateMain' => $dateMain,
            'bookings' => $bookings, 'arrDay' => $arrDay]);
    }

    public function inputAvto(Request $request, $id = null) {
        if ($id) {
            $request = Avto::find($id);
        }
        $avtos = Avto::all();
        return view('car.inputavto', ['car' => $request, 'avtos' => $avtos]);
    }

    public function saveAvto(Request $request) {
        $this->validate($request, [
            'number' => 'required|max:6',
            'model' => 'required|max:30',
            'driver' => 'required|string|max:30',
            'phone_driver' => 'required|digits:10',
            'carphoto' => 'image|max:1000',
                ], [
            'number.required' => 'Номер машины - это обязательное поле',
            'number.max' => 'Номер машины - не более 6 символов',
            'model.required' => 'Модель авто - это обязательное поле',
            'model.max' => 'Модель авто - не более 30 символов',
            'driver.required' => 'Водитель - это обязательное поле',
            'driver.string' => 'Водитель - это текстовое поле',
            'driver.max' => 'Водитель - не более 30 символов',
            'phone_driver.required' => 'Телефон водителя - это обязательное поле',
            'phone_driver.digits' => 'Телефон водителя - не более 10 символов',
            'carphoto.image' => 'Разрешены только картинки',
            'carphoto.max' => 'Размер изображения - не более 1Мб',
        ]);
        if ($request->has('id')) {
            $r = Avto::find($request->id);
            $mes = 'Запись изменена';
        } else {
            $r = new Avto;
            $mes = 'Запись добавлена';
        }
        if ($request->carphoto) {
            if (!file_exists(public_path('img/car'))) {
                @mkdir(public_path('img/car'), 0755);
            }
            $name = Avto::savePhoto($request->carphoto);
            $r->carphoto = $name;
        }
        $r->number = $request->number;
        $r->model = $request->model;
        $r->driver = $request->driver;
        $r->phone_driver = $request->phone_driver;
        $r->save();
        return redirect(action('CarController@inputAvto'))->with('success', $mes);
    }

    public function inputBook($date, Car $car) {
        $name = BryanskPortal::getName(getenv('REMOTE_USER'));
        $nameSlice = explode(" ", $name);
        $phone = Birthday::selectPhoneByName($nameSlice);
        $avtos = Avto::all()->sortBy('viewid');
        $date = date('Y-m-d', strtotime($date));
        $bookings = Booking::getAvtosByDay($date);
        return view('car.editbooking', ['dateBook' => $date, 'avtos' => $avtos,
            'bookings' => $bookings, 'car' => $car, 'name' => $name,
            'phoneMe' => $phone]);
    }

    public function saveBook(\App\Http\Requests\BookingRequest $request) {
        if (($request->time_start + $request->count_time) > 9) {
            return redirect()->back()->with('danger', 'Вы пытаетесь заказать '
                            . 'автомобиль на время после 18:00. (Ночной тариф - '
                            . '2 счетчика ;-) ).');
        }
        $doubleCar = Booking::getOneAvtoByDayAndAvtoId($request->date, $request->id_avto);
        if (count($doubleCar) > 0) {
            foreach ($doubleCar as $car) {
                for ($i = $request->time_start; $i < ($request->time_start + $request->count_time); $i++) {
                    if (($request->time_start >= $car->time_start &&
                            $request->time_start < ($car->time_start + $car->count_time)) ||
                            ($i >= $car->time_start && $i < ($car->time_start + $car->count_time))) {
                        return redirect()->back()->with('danger', 'На это время машина уже забронирована');
                    }
                }
            }
        }
        $r = new Booking;
        $r->id_avto = $request->id_avto;
        $r->who = $request->who;
        $r->target = $request->target;
        $r->ip = ip2long($request->ip);
        $r->phone = $request->phone;
        $r->date = date('Y-m-d', strtotime($request->date));
        $r->time_start = $request->time_start;
        $r->count_time = $request->count_time;
        $r->save();
        if ($request->regions === '1') {
            $regions = true;
        } else {
            $regions = false;
        }
        if (isset($r->id)) {
            $r = Booking::join('avtos', 'avtos.id', '=', 'bookings.id_avto')
                            ->where('bookings.id', $r->id)->first();
            $email = BryanskPortal::getEmail(getenv('REMOTE_USER'));
            $title = "Заявка на автомобиль от сотрудника " . $r->who;
            $this->sendEmail($r, $regions, $title, $email);
        }
        return redirect(action('CarController@main'))
                        ->with("success", "Заявка на поездку добавлена. "
                                . "Сообщите водителю " . $r->driver . " по "
                                . "телефону: +7-" . $r->phone_driver);
    }

    private function sendEmail($r, $regions, $title, $email = null) {
        $mails = NewMail::all();
        foreach ($mails as $mail) {
            $address[] = $mail->email;
        }
        //($r->id_avto == 3)? $address[] = "kudas32@yandex.ru":true;
        ($regions == true) ? $address[] = "regions@bryansk.rgs.ru" : true;
        //dd($address);
        $name = $r->who;
        $text = $title . ' на дату: ' . date('d-m-Y', strtotime($r->date)) . "\r\n" . "\r\n" . "\r\n" .
                'От ' . $name . "\r\n" . "\r\n" .
                'Автомобиль ' . $r->model . ', номер: ' . $r->number . "\r\n" . "\r\n" .
                'Направление/Цель: ' . $r->target . "\r\n" . "\r\n" .
                'Водитель: ' . $r->driver . "\r\n" . "\r\n" .
                'Дата: ' . date('d-m-Y', strtotime($r->date)) . "\r\n" . "\r\n" .
                'C ' . Car::setTimeStart($r->time_start) . ' до ' .
                Car::setTimeStart($r->time_start + $r->count_time);
        Mail::raw($text, function($formail) use($email, $name, $address, $title) {
            $formail->from('report@bryansk.rgs.ru', "Сервис заявок автомобилей");
            $formail->to($address);
            if ($email != null) {
                $formail->cc($email);
            }
            $formail->subject($title);
        });
        return true;
    }

    public function allByMounth(Car $car, $dateMain = null) {
        if (!$dateMain) {
            $dateMain = date('d-m-Y');
        } else {
            $dateMain = date('d-m-Y', strtotime($dateMain));
        }
        $forBook = explode('-', $dateMain);
        $forBook = '01-' . $forBook[1] . '-' . $forBook[2];
        $forBook = [
            'm' => date('m', strtotime($forBook)),
            'y' => date('Y', strtotime($forBook))
        ];
        $bookings = Booking::selectAllDataByMounthAndDay($forBook);
        $mechanits = Avto::select('avtos.*')
                        ->join('bookings', 'bookings.id_avto', '=', 'avtos.id')
                        ->groupBy('avtos.id')->get();
        //dd($mechanits);
        return view('car.bookingsByMounth', ['car' => $car, 'books' => $bookings,
            'dateMain' => $dateMain, 'mechanits' => $mechanits]);
    }

    public function delete($id) {
        $r = Booking::findOrFail($id);
        $rDB = Booking::join('avtos', 'avtos.id', '=', 'bookings.id_avto')
                        ->where('bookings.id', $id)->first();
        $email = BryanskPortal::getEmail(getenv('REMOTE_USER'));
        $name = BryanskPortal::getName(getenv('REMOTE_USER'));
        $name = "Удаление заявки на автомобиль сотрудником " . $name;
        $regions = false;
        $this->sendEmail($rDB, $regions, $name, $email);
        $r->delete();
        return redirect(action('CarController@allByMounth'))->with("success", "Удалено");
    }

}
