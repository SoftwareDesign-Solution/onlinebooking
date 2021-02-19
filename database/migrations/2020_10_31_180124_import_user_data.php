<?php

use App\Events\UserMigratedEvent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ImportUserData extends Migration
{

    public function up()
    {

        if (env('APP_ENV') == 'pipeline') {
            return;
        }

        $oldUsers = $this->fetchUsersFromOldDatabase();

        foreach ($oldUsers as $oldUser) {
            $user = new User();

            $user->name = "$oldUser->first_name $oldUser->last_name";
            $user->email = $oldUser->email;
            $user->email_verified_at = Carbon::now();
            $user->password = $oldUser->password; // users have to reset their password
            $user->created_at = $oldUser->registration_date;
            $user->updated_at = Carbon::now();
            $user->role = $oldUser->access_level == 'admin' ? 'admin' : 'user';
            $user->phone = $oldUser->tel;
            $user->active = $oldUser->enabled;

            $user->save();
            event(new UserMigratedEvent($user));
        }
    }

    public function down()
    {
        if (env('APP_ENV') == 'pipeline') {
            return;
        }

        $oldUsers = $this->fetchUsersFromOldDatabase();

        foreach ($oldUsers as $oldUser) {
            User::where("email", $oldUser->email)->delete();
        }
    }

    private function fetchUsersFromOldDatabase()
    {
        return DB::connection('old_database')->select('SELECT * FROM event_users');
    }

}
