<?php

namespace App\Observers;

use App\Notifications\NewUserRegistered;
use App\Models\TrackEvent;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        \Log::info('User created', ['user' => $user]);
        $data = array(
            'location' => 'signUp',
            'details' => 'Id : '.$user->id.', Name : '.$user->name.', Date : '.date('d-m-Y H:i:a'),
        );
       TrackEvent::create($data);
       $admin = User::where('is_superadmin', 1)->first();
       if($admin) {
            $admin->notify(new NewUserRegistered($user));
        }
    }

 

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
    //    \Log::info('updated');
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        // \Log::info('deleted');
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        // \Log::info('restored');
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {

    }

    public static function signIn(User $user)
    {
        $data = array(
            'location' => 'signIn',
            'details' => 'Id : '.$user->id.', Name : '.$user->name.', Date : '.date('d-m-Y H:i:a'),
        );
       TrackEvent::create($data);
    }

}
