<?php

namespace Wave\Http\Controllers;

use App\Http\Controllers\Controller;
use Wave\CampaignEmail;
use Wave\SmsLog;
use Wave\Campaign;
use App\Models\websites;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('theme::home');
    }


    public function dashboard(){
        $user = Auth()->user(); 
        $role = $user->role_id;
        if ($role === 1) {
           
            $totalEmailSent = $this->getTotalEmailSent();
            $totalSmsSent = $this->getTotalSmsSent();
            $totalCampaigns = $this->getTotalCampaigns();
            $totalConnectedWebsites = $this->getTotalConnectedWebsites();
        } else {
            
            // For regular users, fetch data related to their account (if applicable)
            $totalEmailSent = $this->getTotalEmailSentForUser($role);
            $totalSmsSent = $this->getTotalSmsSentForUser($role);
            $totalCampaigns = $this->getTotalCampaignsForUser($role);
            $totalConnectedWebsites = $this->getTotalConnectedWebsitesForUser($role);
        }

        return view('theme::dashboard.dashboard', compact('totalEmailSent', 'totalSmsSent', 'totalCampaigns', 'totalConnectedWebsites'));
 
        
    }
  // Admin methods
  protected function getTotalEmailSent()
  {
      return CampaignEmail::count();
  }

  protected function getTotalSmsSent()
  {
      return SmsLog::count();
  }

  protected function getTotalCampaigns()
  {
      return Campaign::distinct('id')->count('id');
  }

  protected function getTotalConnectedWebsites()
  {
      return websites::distinct('id')->count('id');
  }

  // User-specific methods
  protected function getTotalEmailSentForUser($userId)
  {
      // Implement logic to fetch user-specific data for email sent
      $web =   CampaignEmail::where('user_id', $userId)->count();
      return $web;
  }

  protected function getTotalSmsSentForUser($userId)
  {
      // Implement logic to fetch user-specific data for SMS sent
      $web = SmsLog::where('user_id', $userId)->count();
      return $web;
  }

  protected function getTotalCampaignsForUser($userId)
  {
      // Implement logic to fetch user-specific data for campaigns
     $web = Campaign::where('UsersID', $userId)->distinct('id')->count('id');
      return $web;
  }

  protected function getTotalConnectedWebsitesForUser($userId)
  {
      // Implement logic to fetch user-specific data for connected websites
    $web =  websites::where('UserID', $userId)->distinct('id')->count('id');
    return $web;
  }
}
