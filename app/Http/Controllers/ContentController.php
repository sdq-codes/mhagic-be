<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomValidationFailed;
use App\Models\Comment;
use App\Models\Contestant;
use App\Models\Fan;
use App\Models\Payment;
use App\Models\Upload;
use App\Models\User;
use App\Models\UserBlock;
use App\Models\Vote;
use App\Models\Wallet;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function fetchAll() {
        $user = Auth::user();
        $uploads = Upload::with('user', 'comments', 'comments.user')
            ->where('to', '=','Upload')
            ->get()->shuffle();
        foreach ($uploads as $key => $upload) {
            if (UserBlock::where([
                ['user_id', $user->id],
                ['contestant_id', $upload->uploadedBy]
            ])->first()) {
                unset($uploads[$key]);
            }
        }
        return response()->fetch(
            'Content successfully fetched',
            $uploads,
            'content'
        );
    }

    public function fundWallet(Request $request) {
        $this->validate($request, [
            "amount" => "required"
        ]);

        $user = Auth::user();

//        return $user;

        $wallet = Wallet::where('userId', $user->id)->first();
        if (is_null($wallet)) {
            throw new AuthenticationException("You need to login to fund your wallet");
        }
        $wallet = Wallet::where('userId', $user->id)->update([
            'oldBalance' => $wallet->newBalance,
            'newBalance' => $wallet->newBalance + $request->amount,
            'amount' => $request->amount
        ]);

        return response()->updated(
            'Wallet successfully funded',
            Wallet::where('userId', $user->id)->first(),
            'wallet'
        );
    }

    public function fetchWallet() {

        $user = Auth::user();

//        return $user;
        $wallet = Wallet::where('userId', $user->id)->first();
        if (is_null($wallet)) {
            throw new AuthenticationException("You need to login to fund your wallet");
        }
        return response()->fetch(
            'Wallet successfully funded',
            $wallet,
            'wallet'
        );
    }

    public function transferTo(Request $request) {
        $this->validate($request, [
            "amount" => "required",
            "phone" => "required",
        ]);
        $user = Auth::user();
        $wallet = Wallet::where('userId', $user->id)->first();
        if (is_null($wallet)) {
            throw new AuthenticationException("You need to login to fund your wallet");
        }
        if ($wallet->newBalance < $request->amount) {
            throw new CustomValidationFailed("You do not have sufficient balance.");
        }
        $receiveUser = User::where('phone', $request->phone)->first();
        if (is_null($receiveUser)) {
            throw new AuthenticationException("No account is tied to the telephone number you entered.");
        }
        $wallet = Wallet::where('userId', $user->id)->update([
            'oldBalance' => $wallet->newBalance,
            'newBalance' => $wallet->newBalance - $request->amount,
            'transferedTo' => $receiveUser->id
        ]);

        $receiveUserWallet = Wallet::where('userId', $receiveUser->id)->first();

        $wallet = Wallet::where('userId', $receiveUser->id)->update([
            'oldBalance' => $receiveUserWallet->newBalance,
            'newBalance' => $receiveUserWallet->newBalance + $request->amount,
            'transferedBy' => $user->id
        ]);

        $wallet = Wallet::where('userId', $user->id)->first();

        return response()->fetch(
            'Wallet successfully funded',
            $wallet,
            'wallet'
        );

    }

    public function vote(Request $request) {
        $this->validate($request, [
            "voteCount" => "required|numeric",
            "voted" => "required",
        ]);

        $user = Auth::user();
        $wallet = Wallet::where('userId', $user->id)->first();
        if (is_null($wallet)) {
            throw new AuthenticationException("You need to login to fund your wallet");
        }
        if ($wallet->newBalance < $request->voteCount) {
            throw new CustomValidationFailed("You do not have sufficient balance.");
        }
        DB::transaction(function () use ($user, $wallet, $request) {
            Wallet::where('userId', $user->id)->update([
                'oldBalance' => $wallet->newBalance,
                'newBalance' => $wallet->newBalance - $request->voteCount
            ]);
            $vote = Vote::create([
                'votedBy' => $user->id,
                'voted' => $request->voted,
                'voteCount' => $request->voteCount
            ]);
        });
        return response()->fetch(
            'Vote successfully funded',
            'successful',
            'vote'
        );
    }

    public function comment(Request $request) {
        $this->validate($request, [
            "uploadId" => "required",
            "commentContent" => "required",
        ]);

        $user = Auth::user();

        $comment = Comment::create([
            "uploadId" => $request->uploadId,
            "content" => $request->commentContent,
            "commentedBy" => $user->id
        ]);

        return response()->fetch(
            'Successfully commented',
            $comment,
            'comment'
        );
    }

    public function contestant($contestantId) {
        return response()->fetch(
            'Successfully fetch contestant',
            Contestant::with('user', 'uploads', 'fans')->where('id', $contestantId)->get(),
            'contestant'
        );
    }

    public function follow($contestantId) {
        $upload = Upload::max('week');
        $user = Auth::user();
        $previouslyFollowed = Fan::where([
            ['follower', $user->id],
            ['following', $contestantId],
            ['week', $upload]
        ])->first();
        if (!is_null($previouslyFollowed)) {
            throw new CustomValidationFailed("You are already following this contestant.");
        }
        $fans = Fan::create([
           "type" => "contestant",
           "follower" => $user->id,
           "following" => $contestantId,
           "week" => $upload,
        ]);
        return response()->fetch(
            'Successfully followed contestant',
            $fans,
            'fan'
        );
    }

    public function fetchProfile() {
        return response()->fetch(
            'Successfully updated profile',
            Auth::user(),
            'profile'
        );
    }

    public function profile(Request $request) {

        $this->validate($request,[
            "firstname" => 'required|string',
            "lastname" => 'required|string',
            "occupation" => 'string',
            "email" => 'email',
            "gender" => 'string',
            "age" => 'numeric',
            "phone" => 'required|numeric',
            "linkedin" => 'string',
            "tiktok" => 'string',
            "twitter" => 'string',
            "instagram" => 'string',
        ]);
        $user = Auth::user();
        User::where('id', $user->id)
            ->update([
                "firstname" => $request->firstname,
                "lastname" => $request->lastname,
                "occupation" => $request->occupation,
                "email" => $request->email,
                "gender" => $request->gender,
                "age" => $request->age,
                "phone" => $request->phone,
                "linkedin" => $request->linkedin,
                "tiktok" => $request->tiktok,
            ]);
        return response()->fetch(
            'Successfully updated profile',
            User::where('id', $user->id)->first(),
            'profile'
        );
    }

    public function block(string $contestantId) {
        $user = Auth::user();
        $block = UserBlock::create([
            "user_id" => $user->id,
            "contestant_id" => $contestantId,
        ]);
        return response()->fetch(
            'Successfully updated profile',
            $block,
            'profile'
        );
    }
    //
}
