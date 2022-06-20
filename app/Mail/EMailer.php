<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Mail;
use Log;
use Auth;
use Config;
use DB;

use App\Models\User;

use Carbon\Carbon;

class EMailer extends Mailable
{
	use Queueable, SerializesModels;
	
	private $blacklist;
	
	public function __construct()
    {
		$blacklist = DB::table('blacklist_emails')->pluck('email');
		$this->blacklist = $blacklist->toArray();
		
	}
	
	public function taskerHiredNotification($task)
	{
		if(in_array($task->tasker->email, $this->blacklist)) return;
		
		Mail::send('emails.tasker.hired-notification', ['task' => $task], function ($m) use ($task) {
			$m->from('support@leadrop.com', 'Leadrop Team');
			$m->to($task->tasker->email, $task->tasker->first_name)
			  ->subject("Congratulations you are hired.");
		});
	}
	
	public function taskUpdateNotification($task)
	{
		Log::info("taskUpdateNotification: " . $task->tasker->email);

		if(in_array($task->tasker->email, $this->blacklist)) return;
		
		Mail::send('emails.tasker.task-updated', ['task' => $task], function ($m) use ($task) {
			$m->from('support@leadrop.com', 'Leadrop Team');
			$m->to($task->tasker->email, $task->tasker->first_name)
			  ->subject(env("APP_NAME") . " - Task has been updated");
		});
	}
	
	public function conversationNotification($conversation)
	{
		if(in_array($conversation->target->email, $this->blacklist)) return;
		
		Mail::send('emails.task.msg-notification', ['conversation' => $conversation], function ($m) use ($conversation) {
			$m->from('support@leadrop.com', 'Leadrop Team');
			$m->to($conversation->target->email, $conversation->target->first_name)
			  ->subject(env("APP_NAME") . " - You have received a new message");
		});
	}
				
}// End of class