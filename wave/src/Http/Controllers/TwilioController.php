<?php

namespace Wave\Http\Controllers;
use App\Http\Controllers\Controller;
use Wave\SmsLog;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use League\Csv\Reader;
use Illuminate\Support\Facades\Log;
use Auth;

class TwilioController extends Controller
{
    public function sendSMSpage(){
        return view("theme::dashboard.smscampaign");
    }
    public function sendSMS(TwilioService $twilioService, Request $request)
{
    try {
        if (empty($request->file('csv_file')) && empty($request->input('number'))) {
            return redirect()->back()->with('message', 'Please provide numbers either via CSV file or form input.');
        }

        if ($request->hasFile('csv_file')) {
            $csvFile = $request->file('csv_file');
            $csv = Reader::createFromPath($csvFile->getPathname());

            $numberColumnIndex = $this->findNumberColumnIndex($csv);

            if ($numberColumnIndex === null) {
                return redirect()->back()->with('message', 'No valid number column found in the CSV file. Must have a contact column in the CSV file.');
            }

            $to = $csv->fetchColumn($numberColumnIndex);


        } else {
            $to = explode(',', $request->input('number'));
        }

        $message = $request->input('message');

        foreach ($to as $recipient) {
            $twilioService->sendSMS($recipient, $message);
            SmsLog::create([
                'recipient' => $recipient,
                'message' => $message,
                'sent_at' => now(),
                'user_id' =>Auth::id(),
            ]);
        }

        return redirect()->back()->with('message', 'SMS sent successfully!');
    } catch (\Exception $e) {
        \Log::error("SMS sending failed. Error: " . $e->getMessage());
        return redirect()->back()->with('message', 'SMS sending failed. Error: ' . $e->getMessage());
    }
}

private function findNumberColumnIndex($csv)
{
    $maxColumnsToCheck = 100;
    $maxRowsToCheck = 10;

    for ($rowIndex = 0; $rowIndex < $maxRowsToCheck; $rowIndex++) {
        $row = $csv->fetchOne();

        if ($row === false) {
            break;
        }

        foreach ($row as $index => $column) {
            if ($this->isNumberColumn($column)) {
                return $index;
            }

            if ($index + 1 >= $maxColumnsToCheck) {
                break;
            }
        }
    }

    return null;
}

private function isNumberColumn($column)
{
    $keywords = ['number', 'Number', 'Phone', 'phone', 'mobile', 'Mobile'];

    foreach ($keywords as $keyword) {

        if (stripos($column, $keyword) !== false) {
            return true;
        }
    }

    return false;
}



    public function sendWhatsAppMessage()
    {
        $to = 'whatsapp:'.$request->input("wnumber");
        $message = 'Hello, this is a test message from From Developer QFN';

        try {
            $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

            $twilio->messages->create(
                $to,
                [
                    'from' => 'whatsapp:' . env('TWILIO_PHONE'),
                    'body' => $message,
                ]
            );

            return 'WhatsApp message sent successfully!';
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
