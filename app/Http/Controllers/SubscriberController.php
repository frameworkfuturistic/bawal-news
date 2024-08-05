<?php

namespace App\Http\Controllers;

use App\Mail\Subscription;
use App\Models\{Comment, Subscriber};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Crypt, Mail, Validator};

class SubscriberController extends Controller
{
    public function subscribe(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email|unique:subscribers|max:30'
        ], [
            'unique' => __('message.you_have_subscribed')
        ]);

        if ($validator->fails()) {
            return [
                'errors' => $validator->errors()
            ];
        }

        $token = hash('sha256', time());
        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->token = $token;
        $subscriber->status = 'Pending';

        $subscriber->save();

        Mail::to($request->email)->send(new Subscription($subscriber));

        return response()->json([
            'success' => __('message.thanks_for_subscribing'),
            'message' => __('message.please_check_inbox')
        ]); 
    }
    
    /**
     * verify
     *
     * @param  mixed $token
     * @param  mixed $email
     * @return void
     */
    public function verify($token, $email)
    {
        $subscriber_data = Subscriber::where('email',$email)->first();
        
        if($subscriber_data) {
            $subscriber_data->token = '';
            $subscriber_data->status = 'Active';
            $subscriber_data->update();

            return redirect()->back()->with('success', __('message.verified_successfully'));
        } else {
            return redirect()->back()->with('error', __('message.unverified_successfully'));
        }
    }
    
    /**
     * unsubcrib
     *
     * @param  mixed $email
     * @return void
     */
    public function unsubcrib($email)
    {
        Subscriber::where('email', $email)->delete();

        return redirect()->back()->with('success', __('message.unsubscribed_successfully'));
    }

    /**
     * unsubscribeVerification
     *
     * @param  mixed $token
     * @return void
     */
    public function unsubscribeCommentReplyVerification($token)
    {
        $comment = Comment::find(Crypt::decryptString($token));

        if ($comment) {
            if ($comment->subscribe == 'y') {

                $comment->subscribe = 'n';
                $comment->save();

                return redirect()->back()->with('success', __('message.unsubscribed_successfully'));
            } else {
                return redirect()->back()->with(['errors' => __('message.comments_has_been_unsubscribe')]);
            }
        }

        return redirect()->back()->with(['errors' => __('message.email_not_found')]);
    }
}
