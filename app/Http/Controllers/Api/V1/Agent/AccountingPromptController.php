<?php

namespace App\Http\Controllers\Api\V1\Agent;

use App\Ai\Agents\AccountingAgent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountingPromptController extends Controller
{
    //
    public function accountingPrompt(Request $request)
    {
        $agent = AccountingAgent::make();
         $response =   $agent->prompt($request->input('prompt'),[],null,env('AI_MODEL'),10000);
 
        return response()->json($response);
    }   
}
