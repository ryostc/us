<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Instructor;
use Illuminate\Support\Facades\Validator;


class UsController extends Controller
{
    public function index(Request $request)
    {
        return view('us.instructorRegister');
    }

    public function instructorRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:3',
        ]);
        if ($validator->fails()) {
            return redirect('/instructors/register')
                ->withInput()
                ->withErrors($validator);
        }
        return view('us.instructorRegister');
    }

    public function post(Request $request)
    {
        return view('us.index', ['msg' => $request->msg]);
    }
}
