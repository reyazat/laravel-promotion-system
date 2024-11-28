<?php

namespace App\Http\Controllers\API;

use App\Actions\Promotion\CheckPromotionAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\DummyResource;
use Illuminate\Http\Request;

class CheckPromotionController extends Controller
{
    public function checkCode(Request $request):DummyResource
    {
        $data = $request->validate([
            'code' => 'required|string',
            'user_id' => 'required|integer',
            'amount' => 'required|numeric|min:500000'
        ]);
        return new DummyResource((new CheckPromotionAction())->execute($data));
    }


}
