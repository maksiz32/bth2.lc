<?php
namespace App\Http\Controllers;

use App\Birthday;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\BirthdayRequest;
use Barryvdh\DomPDF\Facade as PDF;
use App\Email;
use Mail;

class InputController extends Controller
{
    public function __construct()
    {
        $this->middleware('isADEditor')->except('search');
    }
    public function import() {
        return view('importExport');
        }

    public function importExcel(Request $request) {
        $this->validate($request, [
        'import_file' => 'mimes:xlsx',
    ]);
        $iName = 'maksim.' . $request->import_file->getClientOriginalExtension();
        $path = $request->import_file->storeAs('xlsx', $iName, 'my_files');
        
        $inputFileName = $path;
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($inputFileName);
        $worksheet =$spreadsheet->getActiveSheet();

        if($request->hasFile('import_file')){
            $arrErr = null;
            $highestRow = $worksheet->getHighestRow(); 
            $highestColumn = $worksheet->getHighestColumn(); 
            //$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); 
            //-Это, если мы не знаем «ширины» нашей таблицы, но тогда пустые ячейки попадут в наш вывод
            $highestColumnIndex =8; //А здесь мы задаем ширину до H и не более
            for ($row = 6; $row <= $highestRow; $row++) {
                $cellM[0] = 'nameF';
                $cellM[1] = 'nameN';
                $cellM[2] = 'nameOt';
                $cellM[3] = 'work';
                $cellM[4] = 'dolzh';
                $cellM[5] = 'date';
                $arrC = array();
                $AAA = array();
                $AAA1 = array();
                for ($col = 2; $col <= $highestColumnIndex; $col++) {
                    if ($col == 2) {
                        $AAA = explode(" ", $worksheet->getCellByColumnAndRow($col, $row)
                                ->getValue());
                        continue;
                    }
                    if ($col == 4) continue;
                    if ($col == 5) continue;
                    if ($col == 7) continue;
                    $CCC = $worksheet->getCellByColumnAndRow($col, $row)->getDataType();
                    $AAA3 = htmlspecialchars($worksheet->getCellByColumnAndRow($col, $row)->getValue());
                    if($col == 8) {
                    $AAA2 = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($AAA3)->format('d-m-Y');
                        }
                        $AAA1[] = $AAA3;
                }
                    if (isset($AAA2)) {
                        $AAA1[2] = $AAA2;
                    //dd($AAA1);
                        $arrC = array_merge($AAA,$AAA1);
                    }
                    $arrB = array_combine($cellM, $arrC);
                        $DDD = Birthday::where('nameF',$arrB['nameF'])
                                ->where('nameN',$arrB['nameN'])
                                ->where('nameOt',$arrB['nameOt'])
                                ->whereDate('date','=',date('Y-m-d',strtotime($arrB['date'])))
                                ->get();
                    if (!($DDD->isEmpty())) {
                        $arrErr[] = $arrB;
                        unset ($arrB);
                    } else {
                    $data1[] = $arrB;
                    }
                }
                        //dd($data1);
                return view("dop.who", ["dataInp" => $data1, "arrErr" => $arrErr]);
	}
}

    public function save(BirthdayRequest $request) {
        $countArr = count($request->fam);
        for ($i=0; $i<$countArr; $i++){
            $arrInput[$i] = [
                'nameF' => $request->fam[$i],
                'nameN' => $request->name[$i],
                'nameOt' => $request->otch[$i],
                'dolzh' => $request->dolzh[$i],
                'work' => $request->work[$i],
                'date' => date('Y-m-d', strtotime($request->date[$i])),
            ];
        }
        //DB::table('birthdays')->truncate();
        DB::table('birthdays')->insert($arrInput);
        return view("dop.all", ["notes" => Birthday::paginate(10), "mounth" => null]);
}

    public function editOne($id) {
    return view("dop.edit" , ["edit" => Birthday::where('id', $id)->first()]);
}

    public function saveOne(BirthdayRequest $request) {
        $nameZap = $request->nameF . " " . $request->nameN;
        if ($request->has("sw1")) {
            $time_r = time();
            $name = $time_r . '_birthday' . '.' . $request->file('photo')->getClientOriginalExtension();
            $path = $request->file('photo')->storeAs('img/workers', $name, 'my_files');
            $arrUpdate = [
                'nameF' => $request->nameF,
                'nameN' => $request->nameN,
                'nameOt' => $request->nameOt,
                'dolzh' => $request->dolzh,
                'work' => $request->work,
                'phone' => $request->phone,
                'date' => date('Y-m-d', strtotime($request->date)),
                'photo' => $path
                    ];
        } else {
            $arrUpdate = [
                'nameF' => $request->nameF,
                'nameN' => $request->nameN,
                'nameOt' => $request->nameOt,
                'dolzh' => $request->dolzh,
                'phone' => $request->phone,
                'work' => $request->work,
                'date' => date('Y-m-d', strtotime($request->date)),
                    ];
        }
        DB::table('birthdays')->where('id', $request->id)->update($arrUpdate);
        $mounth = explode("-", $request->date);
        return redirect(action('AllController', ['mounth' => (int) $mounth[1]]))
                ->with("status", "Запись о " . $nameZap . " изменена");
}

    public function goPDF($id) {
        return view("pdf.birthday", ["dataB" => Birthday::where('id', $id)->first(), 
            "monthM" => Birthday::monthM($id)]);
}

    public function sendmail($id) {
        $dataC = Birthday::where('id', $id)->first();
        $data = ["dataB" => Birthday::where('id', $id)->first(), 
            "monthM" => Birthday::monthM($id)];
        $name = $dataC->nameF . " " . $dataC->nameN;
        $pathPDF = 'pdf/birthday.pdf';
        $pdf = PDF::loadView('pdf.birthday', $data);
        if ($pdf->save($pathPDF)) {
        $mails = Email::first();
        $mail_add = $mails->email;
        
        Mail::send('pdf.email', $data, function($message) use ($pathPDF, $mail_add) {
            //$message->Host = gethostbyname('tls://smtp.gmail.com');
                $message->from('birthdays@bryansk.rgs.ru', 'Birthday');
                $message->to($mail_add);
                $message->subject('Поздравление с Днем Рождения');
                $message->attach(asset($pathPDF));
            });
            return redirect("/all")->with("status", "Поздравление для " . $name . " отправлено");
        }
        return redirect("/all")->with("status", "Поздравление для " . $name . " не было отправлено");
    }
    
    public function delOne(Birthday $id) {
        $name = $id->nameF . " " . $id->nameN;
        $id->delete();
        return redirect("/all")->with("status", "Запись о " . $name . " удалена");
        }
        
    public function inputOne(BirthdayRequest $request) {
        //list($year, $month, $day) = explode("-",$request->date);
            $DDD = Birthday::where('nameF',$request->nameF)
                    ->where('nameN',$request->nameN)
                    ->where('nameOt',$request->nameOt)
                    ->whereDate('date','=',$request->date)
                    ->get();
            if ($DDD->isEmpty()) {
                if ($request->file('photoFile')!=null) {
                    $time_r = time();
                    $name = $time_r . '_birthday' . '.' . $request->file('photoFile')->getClientOriginalExtension();
                    $path = $request->file('photoFile')->storeAs('img/workers', $name, 'my_files');
                    $request->request->add(['photo' => $path]);
                    //dd($request);
                    }
                Birthday::create($request->all());
                return redirect("/all")->with("status", "Запись " . 
                        $request->nameF . " " . 
                        $request->nameN . " создана");
            } else {
                return redirect("/import")
                        ->with("success", "Запись " . 
                                $request->nameF . " " .
                                $request->nameN . " не создана. "
                                . "Такая запись уже была в базе.");
            }
        }
        
        public function yes() {
            
            $day = date('d', time('now'));
            $month = date('m', time('now'));
            $yestoday = DB::table('birthdays')
                    ->whereMonth('date',$month)
                    ->whereDay('date',$day)->get();
            $count = $yestoday->count();
            
        if ($count > 0) {
            foreach ($yestoday as $yes) {
        $data = ["dataB" => Birthday::where('id', $yes->id)->first(), 
            "monthM" => Birthday::monthM($yes->id)];
        $pathPDF = 'pdf/birthday.pdf';
        $pdf = PDF::loadView('pdf.birthday', $data);
        if ($pdf->save($pathPDF)) {
        $mails = Email::first();
        $mail_add = $mails->email;
        Mail::send('pdf.email', $data, function($message) use ($pathPDF, $mail_add) {
                $message->from('birthdays@bryansk.rgs.ru', 'Birthday');
                $message->to($mail_add);
                $message->subject('Поздравление с Днем Рождения');
                $message->attach(asset($pathPDF));
            });
            }
            sleep(130);
            }
            }
        
        
        }
        
        public function search(BirthdayRequest $request) {
            return view("dop.all", ["notes" => Birthday::where($request->column, 'like', '%' . $request->textSearch . '%')->paginate('1000'),
                'mounth' => null, "mail" => Email::first()]);
        }
}
