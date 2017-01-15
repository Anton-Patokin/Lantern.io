<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Room;
use File;

class RemoveRoom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'room:remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove room and the existing files after 1 week';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $rooms = Room::where('created_at', '<', Carbon::today()->subWeek())->get();
        foreach ($rooms as $room) {
            if ($room->delete()) {
                File::deleteDirectory("public/uploads/" . $room->title);
                File::append('storage/logs/roomRemoved.txt', $room->title."\r\n");
            }
        }
    }
}
