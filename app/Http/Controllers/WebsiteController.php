<?php

namespace App\Http\Controllers;

use App\Models\websites;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
   public function index(){
      $website = websites::all();
      // $connectedWebsitesCount = $this->fetchConnectedWebsitesCount();
    return view('theme::website', compact('website'));
   }

   private function fetchConnectedWebsitesCount()
    {
       
        return 10;
    }
}
