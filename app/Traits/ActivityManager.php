<?php


namespace App\Traits;
use App\Models\User;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

trait ActivityManager
{

    public  function logEntryActivityTime(string $userId): void
    {
        $user = User::find($userId);
        if (!$user){
           return;
        }
        $user->last_activity_entry = Carbon::now();
        $user->save();
        return;
    }

    public function activityLog($userId,$activity,$activity_type = null) : void {
        $user = User::find($userId);
        if (!$user){
            return;
        }
        $user->activity()->create([
            'id' => Uuid::uuid1(),
            'user_id' => $userId,
            'activity_type' => $activity_type,
            'activity' => $activity,
        ]);
        return;
    }


}
