<?php

namespace Wave\Http\Controllers;
use Illuminate\Http\Request;
use Wave\CampaignEmail;
use Wave\SmsLog;
use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use League\Csv\Reader;
use Auth;
use Wave\Campaign;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
public function campaign_index(){

    $latestRecord = Campaign::latest()->first();
    return view("theme::edit_campaign", compact('latestRecord'));
}
public function campaign_create(Request  $request){


    $campaignType = $request->input('campaign_type');
    $userId = auth()->user()->id;

     Campaign::create([
        'campaign_name'=> 'Untitled',
        'campaign_type' => $campaignType,
        'UsersID' => $userId,
        'status' => 'draft',

    ]);

    if ($campaignType == 'Regular email') {
        return redirect()->route("edit_index");
    } elseif ($campaignType == 'Regular SMS') {

        return redirect()->route("to.SMS");
    }
}
public function campaign_open_email($id){
    $emails = CampaignEmail::findOrFail($id);
    return view("theme::read_email", compact('emails'));
}
    public function Mailbuilder(){
        return view('mailbuilder');
    }
    public function update_campaign_title(Request $request)
    {
        $id = $request->input('campID');
        $value = $request->input('value');

        Campaign::where('id', $id)->update(['campaign_name' => $value]);

        return response()->json(['success' => true]);
    }
    public function sendEmail(Request $request)
    {
        try {

            if (empty($request->file('csv_file')) && empty($request->input('to'))) {
                return redirect()->back()->with('message', 'Please provide email addresses either via CSV file or form input.');
            }


            if ($request->hasFile('csv_file')) {

                $csvFile = $request->file('csv_file');
            $csv = Reader::createFromPath($csvFile->getPathname());


            $emailColumnIndex = $this->findEmailColumnIndex($csv);


            if ($emailColumnIndex === null) {
                return redirect()->back()->with('message', 'No valid email column found in the CSV file.Must have email column in csv file.');
            }

            $toEmails = $csv->fetchColumn($emailColumnIndex);
            } else {

                $to = $request->input('to');
                $toEmails = explode(',', $to);
            }

            $subject = $request->input('subject');
            $content = $request->input('content');

            $content = Str::replace('<p>', '', $content);
            $content = Str::replace('</p>', '', $content);


            if (empty($toEmails)) {
                return redirect()->back()->with('message', 'No valid email addresses provided.');
            }

            foreach ($toEmails as $recipient) {
                $campaignData = [
                    'to' => $recipient,
                    'subject' => $subject,
                    'body' => $content,
                ];

                $campaign = CampaignEmail::create([
                    'to' => $recipient,
                    'subject' => $subject,
                    'body' => $content,
                    'status' => 'Draft',
                    'UsersID' => Auth::id(),
                ]);

                $test = SendEmailJob::dispatch($campaignData);

                if ($test) {
                    $campaign->update(['status' => 'sent']);
                } else {
                    $campaign->update(['status' => 'failed']);
                }
            }

            return redirect()->back()->with('message', 'Emails sent successfully!');
        } catch (\Exception $e) {
            \Log::error("Email sending failed. Error: " . $e->getMessage());
            return redirect()->back()->with('message', 'An error occurred while sending emails. Please try again.');
        }
    }

    public function index(){





        return view("theme::dashboard.create-campaign");
    }

    public function inbox()
    {
        $isAdmin = auth()->user()->role_id == 1;

        if ($isAdmin) {

            $campaignEmails = Campaign::paginate(10);
        } else {


            $campaignEmails = Campaign::where('UsersID', auth()->user()->id)->paginate(10);
        }

        return view("theme::inbox", compact('campaignEmails'));
    }
    public function sent()
    {
        $isAdmin = auth()->user()->role_id == 1;

        if ($isAdmin) {
            $campaignEmails = Campaign::where('status', 'sent')->paginate(10);
        } else {
            $campaignEmails = Campaign::where('status', 'sent')
                ->where('UsersID', auth()->user()->id)
                ->paginate(10);
        }

        return view('theme::sent', compact('campaignEmails'));
    }

    public function draft()
    {
        $isAdmin = auth()->user()->role_id == 1;

        if ($isAdmin) {
            $campaignEmails = Campaign::where('status', 'draft')->paginate(10);
        } else {
            $campaignEmails = Campaign::where('status', 'draft')
                ->where('UsersID', auth()->user()->id)
                ->paginate(10);
        }

        return view('theme::draft', compact('campaignEmails'));
    }

    public function EmailInbox()
{
    $isAdmin = auth()->user()->role_id == 1;

    if ($isAdmin) {
        $campaignEmails = CampaignEmail::paginate(10);
    } else {
        $campaignEmails = CampaignEmail::where('user_id', auth()->user()->id)->paginate(10);
    }

    return view("theme::email_inbox", compact('campaignEmails'));
}

    public function SMSInbox(){
        $isAdmin = auth()->user()->role_id == 1;


        if ($isAdmin) {

            $campaignEmails = SmsLog::paginate(15);
        } else {

            $campaignEmails = SmsLog::where('user_id', auth()->user()->id)->paginate(15);
        }
        return view("theme::SMS_inbox", compact('campaignEmails'));
    }





            private function findEmailColumnIndex($csv)
        {

            $maxColumnsToCheck = 100;


            $maxRowsToCheck = 10;


            for ($rowIndex = 0; $rowIndex < $maxRowsToCheck; $rowIndex++) {

                $row = $csv->fetchOne();

                if ($row === false) {

                    break;
                }


                foreach ($row as $index => $column) {


                    if ($this->isEmailColumn($column)) {
                        return $index;
                    }


                    if ($index + 1 >= $maxColumnsToCheck) {
                        break;
                    }
                }
            }

            return null;

        }


        private function isEmailColumn($column)
        {
            $keywords = ['email', 'Email',  'Email Address', 'e-mail', 'E-mail', 'e_mail', 'E_mail', 'e mail', 'E mail',   "@"];

            foreach ($keywords as $keyword) {
                if (stripos($column, $keyword) !== false) {
                    return true;
                }
            }

            return false;
        }




}

