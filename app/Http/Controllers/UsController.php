<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Models\Student;
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
     * インストラクターの詳細画面表示
     *
     * @param Instructor $instructor 詳細を確認したいインストラクターの個人情報
     * @return void
     */
    public function instructorDetailShow(Instructor $instructor)
    {
        return view('us.instructorDetailShow', ['instructor' => $instructor]);
    }

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

    /**
     * 生徒の登録画面
     */
    public function studentRegister()
    {
        $instructors = Instructor::orderBy('created_at', 'asc')->get();
        $statuses = [
            '入校',
            '体験',
            '体験追っかけ',
            '体験非入校',
            '退校'
        ];
        $lesson_types = [
            '個人レッスン月2回',
            '個人レッスン月3回',
            '個人レッスン月4回',
            'ペアレッスン月2回'
        ];
        $param = ['instructors' => $instructors, 'statuses' => $statuses, 'lesson_types' => $lesson_types];
        return view('us.studentRegister', $param);
    }

    /**
     * 生徒の新規登録処理
     *
     * @param Request $request 生徒の入力された個人情報
     */
    public function studentCreate(Request $request)
    {
        // インストラクターのバリデーション処理
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'firstname_ruby' => 'required|max:50',
            'lastname_ruby' => 'required|max:50',
            'sex' => 'required',
            'birthdate' => 'required|max:50',
            'guardian_firstname' => 'max:50',
            'guardian_lastname' => 'max:50',
            'guardian_firstname_ruby' => 'max:50',
            'guardian_lastname_ruby' => 'max:50',
            'relationship' => 'max:30',
            'postcode' => 'required|max:10',
            'prefectures' => 'required|max:50',
            'municipalities' => 'required|max:50',
            'address_building' => 'max:50',
            'phonenumber' => 'required|max:50',
            'email' => 'required|email',
            'comment' => 'required|max:300',
            'instructor_id' => 'required',
            'terms_payment' => 'required',
            'unpaid' => 'required',
            'status' => 'required|max:50',
            'lesson_type' => 'required|max:50',
            'pair_id' => 'max:50',
            'enrollment_date' => 'required',
        ]);

        // インストラクターのバリデーションエラー処理
        if ($validator->fails()) {
            return redirect('/students/register')
                ->withInput()
                ->withErrors($validator);
        }

        // インストラクターの登録処理
        $students = new Student;
        $students->firstname = $request->firstname;
        $students->lastname = $request->lastname;
        $students->firstname_ruby = $request->firstname_ruby;
        $students->lastname_ruby = $request->lastname_ruby;
        $students->sex = $request->sex;
        $students->birthdate = $request->birthdate;
        $students->guardian_firstname = $request->guardian_firstname;
        $students->guardian_lastname = $request->guardian_lastname;
        $students->guardian_firstname_ruby = $request->guardian_firstname_ruby;
        $students->guardian_lastname_ruby = $request->guardian_lastname_ruby;
        $students->relationship = $request->relationship;
        $students->postcode = $request->postcode;
        $students->prefectures = $request->prefectures;
        $students->municipalities = $request->municipalities;
        $students->address_building = $request->address_building;
        $students->phonenumber = $request->phonenumber;
        $students->email = $request->email;
        $students->comment = $request->comment;
        $students->instructor_id = $request->instructor_id;
        $students->terms_payment = $request->terms_payment;
        $students->unpaid = $request->unpaid;
        $students->status = $request->status;
        $students->lesson_type = $request->lesson_type;
        $students->pair_id = -1;
        $students->enrollment_date = $request->enrollment_date;
        $students->expel_date = $request->expel_date;
        $students->trial_lesson_date = $request->trial_lesson_date;
        $students->save();
        return redirect('/students/register');
    }

    /**
     * 生徒の一覧表示
     */
    public function studentShow()
    {
        $students = Student::orderBy('created_at', 'asc')->get();
        return view('us.studentShow', [
            'students' => $students,
        ]);
    }

    /**
     * 生徒の詳細画面表示
     *
     * @param Student $student 詳細を確認したい生徒の個人情報
     * @return void
     */
    public function studentDetailShow(Student $student)
    {
        $personalInstructor = Instructor::find($student->instructor_id);
        $pair_student = Student::find($student->pair_id);
        $param = ['student' => $student, 'pair_student' => $pair_student, 'personalInstructor' => $personalInstructor];
        return view('us.studentDetailShow', $param);
    }

    /**
     * 生徒の編集画面表示
     *
     * @param Student $student 編集したい生徒の個人情報
     * @return void
     */
    public function studentEdit(Student $student)
    {
        $personalInstructor = Instructor::find($student->instructor_id);
        $instructors = Instructor::orderBy('created_at', 'asc')->get();
        $pair_student = Student::find($student->pair_id);
        $statuses = [
            '入校',
            '体験',
            '体験追っかけ',
            '体験非入校',
            '退校'
        ];
        $lesson_types = [
            '個人レッスン月2回',
            '個人レッスン月3回',
            '個人レッスン月4回',
            'ペアレッスン月2回'
        ];
        $param = ['student' => $student, 'pair_student' => $pair_student, 'personalInstructor' => $personalInstructor, 'instructors' => $instructors, 'statuses' => $statuses, 'lesson_types' => $lesson_types];
        return view('us.studentEdit', $param);
    }

    /**
     * 生徒の編集処理
     *
     * @param Request $request 入力された編集したい生徒の個人情報
     * @return void
     */
    public function studentUpdate(Request $request)
    {
        // 生徒のバリデーション処理
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'firstname_ruby' => 'required|max:50',
            'lastname_ruby' => 'required|max:50',
            'sex' => 'required',
            'birthdate' => 'required|max:50',
            'guardian_firstname' => 'max:50',
            'guardian_lastname' => 'max:50',
            'guardian_firstname_ruby' => 'max:50',
            'guardian_lastname_ruby' => 'max:50',
            'relationship' => 'max:30',
            'postcode' => 'required|max:10',
            'prefectures' => 'required|max:50',
            'municipalities' => 'required|max:50',
            'address_building' => 'max:50',
            'phonenumber' => 'required|max:50',
            'email' => 'required|email',
            'comment' => 'required|max:300',
            'instructor_id' => 'required',
            'terms_payment' => 'required',
            'unpaid' => 'required',
            'status' => 'required|max:50',
            'lesson_type' => 'required|max:50',
            'pair_id' => 'max:50',
            'enrollment_date' => 'required',
        ]);

        // 生徒のバリデーションエラー処理
        if ($validator->fails()) {
            return redirect('/students/edit/' . $request->id)
                ->withInput()
                ->withErrors($validator);
        }

        // 更新処理
        $students = Student::find($request->id);
        $students->firstname = $request->firstname;
        $students->lastname = $request->lastname;
        $students->firstname_ruby = $request->firstname_ruby;
        $students->lastname_ruby = $request->lastname_ruby;
        $students->sex = $request->sex;
        $students->birthdate = $request->birthdate;
        $students->guardian_firstname = $request->guardian_firstname;
        $students->guardian_lastname = $request->guardian_lastname;
        $students->guardian_firstname_ruby = $request->guardian_firstname_ruby;
        $students->guardian_lastname_ruby = $request->guardian_lastname_ruby;
        $students->relationship = $request->relationship;
        $students->postcode = $request->postcode;
        $students->prefectures = $request->prefectures;
        $students->municipalities = $request->municipalities;
        $students->address_building = $request->address_building;
        $students->phonenumber = $request->phonenumber;
        $students->email = $request->email;
        $students->comment = $request->comment;
        $students->instructor_id = $request->instructor_id;
        $students->terms_payment = $request->terms_payment;
        $students->unpaid = $request->unpaid;
        $students->status = $request->status;
        $students->lesson_type = $request->lesson_type;
        $students->pair_id = $request->pair_id;
        $students->enrollment_date = $request->enrollment_date;
        $students->expel_date = $request->expel_date;
        $students->trial_lesson_date = $request->trial_lesson_date;
        $students->save();
        return redirect('/students/detail/' . $students->id);
    }

    /**
     * 生徒の削除
     *
     * @param Instructor $instructor 削除したいインストラクターの情報
     * @return void
     */
    public function studentDestroy(Student $student)
    {
        $student->delete();
        return redirect('/students/show');
    }
}
