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
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'firstname_ruby' => 'required|max:50',
            'lastname_ruby' => 'required|max:50',
            'enrollment_date' => 'required|date',
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
