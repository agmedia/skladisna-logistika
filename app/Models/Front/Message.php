<?php

namespace App\Models\Front;


use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Message extends Model
{

    /**
     * @var string
     */
    protected $table = 'messages';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Request
     */
    protected $request;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sender()
    {
        return $this->hasOne(User::class, 'id', 'from_user_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function recipient()
    {
        return $this->hasOne(User::class, 'id', 'to_user_id');
    }


    /**
     * @param $query
     * @param $message
     *
     * @return mixed
     */
    public function scopeConversation($query, $message)
    {
        return $query->where('group_id', $message->group_id)->orderBy('created_at', 'desc');
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeInbox($query)
    {
        return $query->where('to_user_id', auth()->user()->id)
                     ->orWhere('from_user_id', auth()->user()->id)
                     ->orderBy('created_at', 'desc')
                     ->groupBy('subject');
    }


    /**
     * @param Request $request
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'message' => 'required'
        ]);

        $this->setRequest($request);

        return $this;
    }


    /**
     * @return bool
     */
    public function store()
    {
        $admin = User::where('email', config('mail.admin'))->first();

        $stored = $this->insertGetId([
            'group_id'        => $this->request->group_id,
            'from_user_id'    => auth()->user()->id,
            'to_user_id'      => $admin->id,
            'name'            => '',
            'email'           => '',
            'subject'         => $this->request->subject,
            'message_content' => $this->request->message,
            'session'         => '',
            'created_at'      => Carbon::now(),
            'updated_at'      => Carbon::now()
        ]);

        if ($stored) {
            return $this->find($stored);
        }

        return false;
    }


    /**
     * Set Model request variable.
     *
     * @param $request
     */
    private function setRequest($request)
    {
        $this->request = $request;
    }

}
