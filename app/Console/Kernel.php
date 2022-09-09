<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Http\Helpers\ParserContent;
use App\Http\Helpers\ParserLinks;
use Illuminate\Support\Facades\Log;
use App\Models\Information;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
			 $rss = 'https://www.securitylab.ru/_services/export/rss/';

			$links = ParserLinks::getLinksYesterday($rss);

			if($links){
				foreach ($links as $link){
					$parser = new ParserContent;
					$content = $parser->getContent($link);
					if($content->allowed){
						Information::create([
							'title' => $content->title,
							'preview' => $content->preview,
							'description' => $content->description,
							'image' => $content->image,
							'link' => $content->link						
						]);
						Log::channel('news')->info('Добавлено: ', ['name' => $content->title, 'link' => $content->link ]);
					}
				}
            }else {
				Log::channel('news')->info('Ссылки не получены.');
			}                     
        })->cron('* * * 14 30');
		
		
		
		
		// $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
