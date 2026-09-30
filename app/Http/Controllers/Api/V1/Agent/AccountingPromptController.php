<?php

namespace App\Http\Controllers\Api\V1\Agent;

use App\Ai\Agents\AccountingAgent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Enums\Lab;

#[Provider(Lab::Ollama)]
#[Model('llama3.2:1b')]

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
             return $response = (new AccountingAgent())
                ->stream(
                    $prompt,
                    provider: 'ollama',
                    model: env('AI_MODEL'),
                    timeout: (int) env('AI_TIMEOUT', 300),
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
