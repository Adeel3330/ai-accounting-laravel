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
        $prompt = $request->input('prompt');
        $request->validate([
            'prompt' => 'required|string',
        ]);
        try {
            
            // $agent = AccountingAgent::make();
            $response =   (new AccountingAgent())
                ->prompt(
                    $prompt,
                    provider: "ollama",
                    model: env('AI_MODEL'),
                );

            return response()->json([
                'status' => 'success',
                'prompt' => $request->input('prompt'),
                'response' => (string) $response,

            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ], 500);

        }
    }
}
