<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\BookingController;

class DeleteExpiredBookings extends Command
{
    protected $signature = 'bookings:delete-expired';
    protected $description = 'Delete expired bookings';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = new BookingController();
        $controller->deleteExpiredBookings();

        $this->info('Expired bookings deleted successfully');
    }
}
