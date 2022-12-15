<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use Illuminate\Support\Facades\Validator;

class UsController extends Controller
{
    /**
     * インストラクター登録画面
     */
    public function instructorRegister()
    {
        return view('us.instructorRegister');
    }

    /**
     * インストラクターの新規登録処理
     *
     * @param Request $request インストラクターの入力された個人情報
     */
    public function instructorCreate(Request $request)
    {
        // インストラクターのバリデーション処理
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'firstname_ruby' => 'required|max:50',
            'lastname_ruby' => 'required|max:50',
            'enrollment_date' => 'required|date',
        ]);

        // インストラクターのバリデーションエラー処理
        if ($validator->fails()) {
            return redirect('/instructors/register')
                ->withInput()
                ->withErrors($validator);
        }

        // インストラクターの登録処理
        $instructors = new Instructor;
        $instructors->firstname = $request->firstname;
        $instructors->lastname = $request->lastname;
        $instructors->firstname_ruby = $request->firstname_ruby;
        $instructors->lastname_ruby = $request->lastname_ruby;
        $instructors->enrollment_date = $request->enrollment_date;

        // $enroll = $request->enrollment_date;
        // dd($enroll);

        // 文字列をUnixタイムスタンプに変換
        // strtotime($enroll);
        // dd(date('Y年m月d日', strtotime($enroll)));
        // dd(strtotime($enroll));

        // $s1 = substr($enroll, 0, 4);
        // dd($s1);

        // $s2 = substr($enroll, 5, 2);
        // dd($s2);

        // $s3 = substr($enroll, 8, 2);
        // dd($s3);

        $instructors->save();
        return redirect('/instructors/register');
    }

    /**
     * インストラクターの一覧表示
     */
    public function instructorShow()
    {
        $instructors = Instructor::orderBy('created_at', 'asc')->get();
        return view('us.instructorShow', [
            'instructors' => $instructors,
        ]);
    }

    /**
     * インストラクターの編集画面表示
     *
     * @param Request $request
     * @return void
     */
    /**
     * インストラクターの編集画面表示
     *
     * @param Instructor $instructor 編集したいインストラクターの個人情報
     * @return void
     */
    public function instructorEdit(Instructor $instructor)
    {
        return view('us.instructorEdit', ['instructor' => $instructor]);
    }

    /**
     * インストラクターの編集処理
     *
     * @param Request $request 入力された編集したいインストラクターの個人情報
     * @return void
     */
    public function instructorUpdate(Request $request)
    {
        // インストラクターのバリデーション処理
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'firstname_ruby' => 'required|max:50',
            'lastname_ruby' => 'required|max:50',
            'enrollment_date' => 'required|date',
        ]);

        // インストラクターのバリデーションエラー処理
        if ($validator->fails()) {
            return redirect('/instructors/edit/' . $request->id)
                ->withInput()
                ->withErrors($validator);
        }

        // 更新処理
        $instructors = Instructor::find($request->id);
        $instructors->firstname = $request->firstname;
        $instructors->lastname = $request->lastname;
        $instructors->firstname_ruby = $request->firstname_ruby;
        $instructors->lastname_ruby = $request->lastname_ruby;
        $instructors->enrollment_date = $request->enrollment_date;
        $instructors->save();
        return redirect('/instructors/show');
    }

    /**
     * インストラクターの削除
     *
     * @param Instructor $instructor 削除したいインストラクターの情報
     * @return void
     */
    public function instructorDestroy(Instructor $instructor)
    {
        $instructor->delete();
        return redirect('/instructors/show');
    }
}
