<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UsController extends Controller
{
    // ステータスの種類の配列
    private $statuses = [
        '入校',
        '体験',
        '体験追っかけ',
        '体験非入校',
        '退校'
    ];

    // レッスンタイプの種類の配列
    private $lesson_types = [
        '個人レッスン月2回',
        '個人レッスン月3回',
        '個人レッスン月4回',
        'ペアレッスン月2回'
    ];

    private function createCalender()
    {
        // タイムゾーンを設定
        date_default_timezone_set('Asia/Tokyo');

        // 前月・次月リンクが押された場合は、GETパラメーターから年月を取得
        if (isset($_GET['ym'])) {
            $ym = $_GET['ym'];
        } else {
            // 今月の年月を表示
            $ym = date('Y-m');
        }

        $thismonth = date('Y-m');

        // タイムスタンプを作成し、フォーマットをチェックする
        $timestamp = strtotime($ym . '-01');
        if ($timestamp === false) {
            $ym = date('Y-m');
            $timestamp = strtotime($ym . '-01');
        }

        // 今日の日付 フォーマット　例）2021-06-3
        $today = date('Y-m-j');

        // カレンダーのタイトルを作成　例）2021年6月
        $html_title = date('Y年n月', $timestamp);

        // 前月・次月の年月を取得
        // 方法：mktimeを使う mktime(hour,minute,second,month,day,year)
        $prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp) - 1, 1, date('Y', $timestamp)));
        $next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp) + 1, 1, date('Y', $timestamp)));

        // 該当月の日数を取得
        $day_count = date('t', $timestamp);

        // １日が何曜日か　0:日 1:月 2:火 ... 6:土
        $youbi = date('w', $timestamp);

        // カレンダー作成の準備
        $weeks = [];
        $week = '';

        // 第１週目：空のセルを追加
        // 例）１日が火曜日だった場合、日・月曜日の２つ分の空セルを追加する
        $week .= str_repeat('<td></td>', $youbi);

        for ($day = 1; $day <= $day_count; $day++, $youbi++) {

            // 2021-06-3
            $date = $ym . '-' . $day;

            if ($today == $date) {
                // 今日の日付の場合は、class="bg-warning"をつける
                $week .= '<td class="bg-warning">';
            } else {
                $week .= '<td>';
            }
            $week .= '<a href=http://localhost/schedules/basic/' . $ym . '/' . $day . '>' . $day . '</a></td>';

            // 週終わり、または、月終わりの場合
            if ($youbi % 7 == 6 || $day == $day_count) {

                if ($day == $day_count) {
                    // 月の最終日の場合、空セルを追加
                    // 例）最終日が水曜日の場合、木・金・土曜日の空セルを追加
                    $week .= str_repeat('<td></td>', 6 - $youbi % 7);
                }

                // weeks配列にtrと$weekを追加する
                $weeks[] = '<tr>' . $week . '</tr>';

                // weekをリセット
                $week = '';
            }
        }

        return array($prev, $next, $weeks, $html_title, $thismonth);
    }

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
     * インストラクターの削除テスト
     *
     * @param Instructor $instructor 削除したいインストラクターの情報
     * @return void
     */
    public function instructorRemove(Request $request)
    {
        DB::table('instructors')->where('id', $request->id)->delete();
        return redirect('/instructors/show');
    }

    /**
     * 生徒の登録画面
     */
    public function studentRegister()
    {
        $instructors = Instructor::orderBy('created_at', 'asc')->get();
        $statuses = $this->statuses;
        $lesson_types = $this->lesson_types;
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
        $instructors = Instructor::orderBy('created_at', 'asc')->get();
        $param = ['students' => $students, 'instructors' => $instructors];
        return view('us.studentShow', $param);
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
        $statuses = $this->statuses;
        $lesson_types = $this->lesson_types;
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
     * @param Request $request 削除したい生徒のidを保持
     * @return void
     */
    public function studentRemove(Request $request)
    {
        DB::table('students')->where('id', $request->id)->delete();
        return redirect('/students/show');
    }

    /**
     * 生徒の検索画面
     */
    public function studentSearchScreen()
    {
        $statuses = $this->statuses;
        $lesson_types = $this->lesson_types;
        $param = ['statuses' => $statuses, 'lesson_types' => $lesson_types];
        return view('us.studentSearch', $param);
    }

    /**
     * 生徒の検索処理
     */
    public function studentSearch(Request $request)
    {
        $students = DB::table('students')
            ->where('firstname', 'like', '%' . $request->firstname . '%')
            ->where('lastname', 'like', '%' . $request->lastname . '%')
            ->where('firstname_ruby', 'like', '%' . $request->firstname_ruby . '%')
            ->where('lastname_ruby', 'like', '%' . $request->lastname_ruby . '%')
            ->where('phonenumber', 'like', '%' . $request->phonenumber . '%')
            ->where('email', 'like', '%' . $request->email . '%')
            ->where('status', 'like', '%' . $request->status . '%')
            ->where('lesson_type', 'like', '%' . $request->lesson_type . '%')
            ->where('unpaid', 'like', '%' . $request->unpaid . '%')
            ->get();
        $instructors = Instructor::orderBy('created_at', 'asc')->get();
        $param = ['students' => $students, 'instructors' => $instructors];
        return view('us.studentSearchResult', $param);
    }

    /**
     * 生徒管理画面の表示
     */
    public function studentControl()
    {
        return view('us.studentControl');
    }

    /**
     * 生徒管理画面の表示
     */
    public function scheduleControl()
    {
        [$prev, $next, $weeks, $html_title, $thismonth] = $this->createCalender();
        $param = ['prev' => $prev, 'next' => $next, 'weeks' => $weeks, 'html_title' => $html_title, 'thismonth' => $thismonth];
        return view('us.scheduleControl', $param);
    }

    /**
     * 生徒管理画面の表示
     */
    public function scheduleBasic($ym, $j)
    {
        $y = substr($ym, 0, 4);
        $m = substr($ym, 5, 2);
        [$prev, $next, $weeks, $html_title, $thismonth] = $this->createCalender();
        $param = ['y' => $y, 'm' => $m, 'j' => $j, 'prev' => $prev, 'next' => $next, 'weeks' => $weeks, 'html_title' => $html_title, 'thismonth' => $thismonth];
        return view('us.scheduleBasic', $param);
    }
}
