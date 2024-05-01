<?php

namespace App\Http\Controllers;

use App\Models\Design;
use Wave\Campaign;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignController extends Controller
{
    public function index($id)
    {
        $templateid = Campaign::findOrFail($id);
        // Fetch templates from the database
        $templates = Design::all();

        return view('theme::templates.index', compact('templates', 'templateid'));
    }
    public function showEditor($id)
    {
        // Fetch a specific template by ID
        $template = Design::findOrFail($id);

        return view('theme::templates.editor', compact('template'));
    }
    public function saveDesign(Request $request)
    {
        
        $requestData = $request->json()->all();
        // $htmlContent = $requestData;
        $designjson = $requestData['design'];
        $designHtml = $requestData['designHtml'];
        

        $userId = Auth::id();
        // Save to the database
        $design = new Design();
        $design->html_content = json_encode($designjson);
        $design->design_content =json_encode($designHtml);
        $design->user_id = $userId;
        $design->save();

        return response()->json(['message' => 'Design saved successfully']);
    }
}
