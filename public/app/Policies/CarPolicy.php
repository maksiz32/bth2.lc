<?php
namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Booking;
use App\BryanskPortal;

class CarPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    //Не использую
    public function manipulate(Booking $book) {
        $user = getenv('REMOTE_USER');
        dd($user);
        return (BryanskPortal::isAdmin($user) || 
                $book->who == BryanskPortal::getName($user));
    }
}
