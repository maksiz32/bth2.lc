<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use App\Birthday;
use Barryvdh\DomPDF\Facade as PDF;
use App\Email;
use Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
            $day = date('d', time('now'));
            $month = date('m', time('now'));
            $yestoday = DB::table('birthdays')->whereMonth('date',$month)->whereDay('date',$day)->get();
            $count = $yestoday->count();
            if ($count > 0) {
                foreach ($yestoday as $yes) {
                    $data = ["dataB" => Birthday::where('id', $yes->id)->first(), 
                        "monthM" => Birthday::monthM($yes->id)];
                    $pathPDF = 'c:\openserver\domains\bth2.lc\public\pdf\birthday.pdf';
                    $pdf = PDF::loadView('pdf.timebirthday', $data);
                    if ($pdf->save($pathPDF)) {
                        $mails = Email::first();
                        $mail_add = $mails->email;
                        Mail::send('pdf.email', $data, function($message) use ($pathPDF, $mail_add) {
                            $message->from('birthdays@bryansk.rgs.ru', 'Birthday');
                            $message->to($mail_add);
                            $message->subject('Поздравление с Днем Рождения');
                            $message->attach($pathPDF);
                        });
                    } else {
                        $mails = Email::first();
                        $mail_add = $mails->email;
                        Mail::send('pdf.email', $data, function($message) use ($mail_add) {
                            $message->from('birthdays@bryansk.rgs.ru', 'Birthday');
                            $message->to($mail_add);
                            $message->subject('Поздравление с Днем Рождения');
                        });
                    }
                    sleep(130);
                }
            }
        })->dailyAt('08:00');

        //Для отчета по серверной:
        /*
        $schedule->call(function() {
            $netPath = '\\\\ktj-fs-01.rgs.ru\regions$\Кроссовые комнаты\Брянская область\Дирекция';
            $dirDate = date('m.Y', time());
            $letter = ['A', 'B', 'C'];
            foreach($letter as $let) {
                ${"arr".$let} = Photoorder::getPathImagesByLetter($let)->toArray();
            }
            foreach($letter as $let) {
                ${"arrKey".$let} = array_rand(${"arr".$let}, 3);
            }
            if(!file_exists("\"{$netPath}\\{$dirDate}\"")) {
                $commandLan = "mkdir \"{$netPath}\\{$dirDate}\"";
                $textPhp = iconv('UTF-8', 'cp1251', $commandLan);//Конвертирую в Windows-1251 (ANSI)
                exec($textPhp);
            }

            $pathMy = public_path().'/img/server/';
            $pathLan = "{$netPath}\\{$dirDate}";
            $pathLan = iconv('UTF-8', 'cp1251', $pathLan);//Конвертирую в Windows-1251 (ANSI)
            foreach($arrKeyA as $arr) {
                $newName = uniqid() . uniqid();
                $ext = (new SplFileInfo($pathMy.$arrA[$arr]['path']))->getExtension();
                copy($pathMy.$arrA[$arr]['path'], "{$pathLan}\\{$newName}.{$ext}");
            }
            foreach($arrKeyB as $arr) {
                $newName = uniqid() . uniqid();
                $ext = (new SplFileInfo($pathMy.$arrB[$arr]['path']))->getExtension();
                copy($pathMy.$arrB[$arr]['path'], "{$pathLan}\\{$newName}.{$ext}");
            }
            foreach($arrKeyC as $arr) {
                $newName = uniqid() . uniqid();
                $ext = (new SplFileInfo($pathMy.$arrC[$arr]['path']))->getExtension();
                copy($pathMy.$arrC[$arr]['path'], "{$pathLan}\\{$newName}.{$ext}");
            }
            НАДО ДОБАВИТЬ ОТПРАВКУ МЫЛА МНЕ, ЧТО ТАКИЕ-ТО ФОТКИ ВЫЛОЖЕНЫ УСПЕШНО
        })->monthlyOn(10, '10:00');
        */
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
