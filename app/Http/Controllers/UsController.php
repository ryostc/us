<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Models\Student;
use App\Models\Schedule;
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

    // レッスンの時間の種類の配列
    private $lesson_times = [
        '10:00',
        '11:00',
        '12:00',
        '13:00',
        '14:00',
        '15:00',
        '16:00',
        '17:00',
        '18:00',
        '19:00',
        '20:00',
        '21:00',
        '22:00'
    ];

    // インストラクターのバリデーションルール
    private $instructorValidationRules = [
        'firstname' => 'required|max:50',
        'lastname' => 'required|max:50',
        'firstname_ruby' => 'required|max:50',
        'lastname_ruby' => 'required|max:50',
        'enrollment_date' => 'required|date',
    ];

    // インストラクターのバリデーションメッセージ
    private $instructorValidationMessages = [
        'firstname.required' => '性は必ず入力して下さい',
        'firstname.max' => '性は50文字以下で入力して下さい',
        'lastname.required' => '名は必ず入力して下さい',
        'lastname.max' => '名は50文字以下で入力して下さい',
        'firstname_ruby.required' => '性(フリガナ)は必ず入力して下さい',
        'firstname_ruby.max' => '性(フリガナ)は50文字以下で入力して下さい',
        'lastname_ruby.required' => '名(フリガナ)は必ず入力して下さい',
        'lastname_ruby.max' => '名(フリガナ)は50文字以下で入力して下さい',
        'enrollment_date.required' => '入校日は必ず入力して下さい',
        'enrollment_date.date' => '入校日はdate型で入力して下さい',
    ];

    // 生徒のバリデーションルール
    private $studentValidationRules = [
        'firstname' => 'required|max:50',
        'lastname' => 'required|max:50',
        'firstname_ruby' => 'required|max:50',
        'lastname_ruby' => 'required|max:50',
        'sex' => 'required',
        'birthdate' => 'required',
        'guardian_firstname' => 'max:50',
        'guardian_lastname' => 'max:50',
        'guardian_firstname_ruby' => 'max:50',
        'guardian_lastname_ruby' => 'max:50',
        'relationship' => 'max:30',
        'postcode' => 'required|max:8',
        'prefectures' => 'required|max:50',
        'municipalities' => 'required|max:50',
        'address_building' => 'max:200',
        'phonenumber' => 'required|max:20',
        'email' => 'required|email',
        'comment' => 'max:300',
        'instructor_id' => 'required',
        'terms_payment' => 'required',
        'unpaid' => 'required',
        'status' => 'required',
        'lesson_type' => 'required',
        'pair_id' => 'max:50',
    ];

    // 生徒のバリデーションメッセージ
    private $studentValidationMessages = [
        'firstname.required' => '性は必ず入力して下さい',
        'firstname.max' => '性は50文字以下で入力して下さい',
        'lastname.required' => '名は必ず入力して下さい',
        'lastname.max' => '名は50文字以下で入力して下さい',
        'firstname_ruby.required' => '性(フリガナ)は必ず入力して下さい',
        'firstname_ruby.max' => '性(フリガナ)は50文字以下で入力して下さい',
        'lastname_ruby.required' => '名(フリガナ)は必ず入力して下さい',
        'lastname_ruby.max' => '名(フリガナ)は50文字以下で入力して下さい',
        'sex.required' => '性別は必ず入力して下さい',
        'birthdate.required' => '誕生日は必ず入力して下さい',
        'guardian_firstname.max' => '保護者 性は50文字以下で入力して下さい',
        'guardian_lastname.max' => '保護者 名は50文字以下で入力して下さい',
        'guardian_firstname_ruby.max' => '保護者 性(フリガナ)は50文字以下で入力して下さい',
        'guardian_lastname_ruby.max' => '保護者 名(フリガナ)は50文字以下で入力して下さい',
        'relationship.max' => '続柄は50文字以下で入力して下さい',
        'postcode.required' => '郵便番号は必ず入力して下さい',
        'postcode.max' => '郵便番号は8文字以下で入力して下さい',
        'prefectures.required' => '都道府県は必ず入力して下さい',
        'prefectures.max' => '都道府県は50文字以下で入力して下さい',
        'municipalities.required' => '市区町村は必ず入力して下さい',
        'municipalities.max' => '市区町村は50文字以下で入力して下さい',
        'address_building.max' => '番地・建物名等は200文字以下で入力して下さい',
        'phonenumber.required' => '電話番号は必ず入力して下さい',
        'phonenumber.max' => '電話番号は20文字以下で入力して下さい',
        'email.required' => 'メールアドレスは必ず入力して下さい',
        'email.email' => 'メールアドレスはemail形式で入力して下さい',
        'comment.max' => 'コメントは300文字以下で入力して下さい',
        'instructor_id.required' => '担当インストラクターは必ず入力して下さい',
        'terms_payment.required' => '支払い方法は必ず入力して下さい',
        'unpaid.required' => '未払いは必ず入力して下さい',
        'status.required' => 'ステータスは必ず入力して下さい',
        'lesson_type.required' => 'レッスンタイプは必ず入力して下さい',
        'pair_id.required' => 'ペアのidは必ず入力して下さい(ペアを設定しない場合は-1を入力して下さい)',
        'pair_id.max' => 'ペアのidは50文字以下で入力して下さい',
    ];

    /**
     * 在籍生徒数をカウントするメソッド
     *
     * @return 在籍生徒数
     */
    public function countEnrolledStudents()
    {
        $count = 0;
        $enrolledStudents = DB::table('students')->where('status', '入校')->get();
        $count = $enrolledStudents->count();
        return $count;
    }

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
        $rules = $this->instructorValidationRules;
        $messages = $this->instructorValidationMessages;

        // インストラクターのバリデーション処理
        $validator = Validator::make($request->all(), $rules, $messages);

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
        $rules = $this->instructorValidationRules;
        $messages = $this->instructorValidationMessages;

        // インストラクターのバリデーション処理
        $validator = Validator::make($request->all(), $rules, $messages);

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
        $rules = $this->studentValidationRules;
        $messages = $this->studentValidationMessages;

        // 生徒のバリデーション処理
        $validator = Validator::make($request->all(), $rules, $messages);

        // 生徒のバリデーションエラー処理
        if ($validator->fails()) {
            return redirect('/students/register')
                ->withInput()
                ->withErrors($validator);
        }

        // 生徒の登録処理
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
        $param = [
            'student' => $student,
            'pair_student' => $pair_student,
            'personalInstructor' => $personalInstructor,
            'instructors' => $instructors,
            'statuses' => $statuses,
            'lesson_types' => $lesson_types
        ];
        return view('us.studentEdit', $param);
    }

    /**
     * ペア生徒の検索画面
     */
    public function pairStudentSearchScreen(Request $request)
    {
        $statuses = $this->statuses;
        $lesson_types = $this->lesson_types;
        $param = [
            'statuses' => $statuses,
            'lesson_types' => $lesson_types,
            'student_id' => $request->id,
        ];
        return view('us.pairStudentSearch', $param);
    }

    /**
     * ペア生徒の検索処理
     */
    public function pairStudentSearch(Request $request)
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
        $param = [
            'students' => $students,
            'instructors' => $instructors,
            'student_id' => $request->student_id
        ];
        return view('us.pairStudentSearchResult', $param);
    }

    /**
     * ペア生徒の編集画面表示
     *
     * @param Student $student 編集したい生徒の個人情報
     * @return void
     */
    public function pairStudentEdit(Request $request)
    {
        $student = Student::find($request->id);
        $personalInstructor = Instructor::find($student->instructor_id);
        $instructors = Instructor::orderBy('created_at', 'asc')->get();
        $pair_student = Student::find($request->pairStudent_id);
        $statuses = $this->statuses;
        $lesson_types = $this->lesson_types;
        $param = [
            'student' => $student,
            'pair_student' => $pair_student,
            'personalInstructor' => $personalInstructor,
            'instructors' => $instructors,
            'statuses' => $statuses,
            'lesson_types' => $lesson_types
        ];
        return view('us.pairStudentEdit', $param);
    }

    /**
     * ペア登録の削除
     */
    public function pairStudentRemove(Request $request)
    {
        if ($request->pair_id != -1) {
            $pariStudent = Student::find($request->pair_id);
            $pariStudent->pair_id = -1;
            $pariStudent->save();
            $students = Student::find($request->id);
            $students->pair_id = -1;
            $students->save();
        }

        // リダイレクトするURL
        $url = '/students/control';

        return redirect($url);
    }

    /**
     * 生徒の編集処理
     *
     * @param Request $request 入力された編集したい生徒の個人情報
     * @return void
     */
    public function studentUpdate(Request $request)
    {
        $rules = $this->studentValidationRules;
        $rules = array_merge($rules, array('pair_id' => 'required'));

        $messages = $this->studentValidationMessages;

        // 生徒のバリデーション処理
        $validator = Validator::make($request->all(), $rules, $messages);

        // 生徒のバリデーションエラー処理
        if ($validator->fails()) {
            return redirect('/students/edit/' . $request->id)
                ->withInput()
                ->withErrors($validator);
        }

        if ($request->pair_id != -1) {
            $pariStudent = Student::find($request->pair_id);
            $pariStudent->pair_id = $request->id;
            $pariStudent->save();
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
     * スケジュール管理画面の表示
     */
    public function scheduleControl()
    {
        // 在籍生徒数を表示するための情報を取得
        $enrolledStudentCount = $this->countEnrolledStudents();

        // カレンダーの作成のための情報を取得
        [$prev, $next, $weeks, $html_title, $thismonth] = $this->createCalender();
        $param = [
            'prev' => $prev,
            'next' => $next,
            'weeks' => $weeks,
            'html_title' => $html_title,
            'thismonth' => $thismonth,
            'enrolledStudentCount' => $enrolledStudentCount
        ];
        return view('us.scheduleControl', $param);
    }

    /**
     * 該当する日付のスケジュールを表示
     */
    public function scheduleBasic($ym, $j)
    {
        $lesson_times = $this->lesson_times;

        // 日付の0埋めなし
        $day = $ym . "-" . $j;
        // 日付の0埋めあり
        $date = date('Y-m-d', strtotime($day));

        $y = date('Y', strtotime($day));
        $n = date('n', strtotime($day));

        // 該当するスケジュールの検索
        $schedules = DB::table('schedules')
            ->where('date', $date)
            ->get();

        // 在籍生徒数を表示するための情報を取得
        $enrolledStudentCount = $this->countEnrolledStudents();

        // カレンダーの作成のための情報を取得
        [$prev, $next, $weeks, $html_title, $thismonth] = $this->createCalender();

        $param = [
            'date' => $date,
            'lesson_times' => $lesson_times,
            'schedules' => $schedules,
            'y' => $y,
            'n' => $n,
            'j' => $j,
            'prev' => $prev,
            'next' => $next,
            'weeks' => $weeks,
            'html_title' => $html_title,
            'thismonth' => $thismonth,
            'enrolledStudentCount' => $enrolledStudentCount
        ];
        return view('us.scheduleBasic', $param);
    }

    /**
     * スケジュール新規登録画面の表示(生徒情報を入れる前)
     */
    public function scheduleRegister($date, $time)
    {
        $ym = date('Y-m', strtotime($date));
        $j = date('j', strtotime($date));
        // リダイレクトするURL
        $url = "schedules/basic/";
        $url .= $ym;
        $url .= "/";
        $url .= $j;

        $lesson_times = $this->lesson_times;

        // 在籍生徒数を表示するための情報を取得
        $enrolledStudentCount = $this->countEnrolledStudents();
        // カレンダーの作成のための情報を取得
        [$prev, $next, $weeks, $html_title, $thismonth] = $this->createCalender();
        $param = [
            'date' => $date,
            'lesson_times' => $lesson_times,
            'ym' => $ym,
            'j' => $j,
            'time' => $time,
            'prev' => $prev,
            'next' => $next,
            'weeks' => $weeks,
            'html_title' => $html_title,
            'thismonth' => $thismonth,
            'enrolledStudentCount' => $enrolledStudentCount
        ];
        return view('us.scheduleRegister', $param);
    }

    /**
     * スケジュール新規登録の検索画面の表示
     */
    public function scheduleRegisterSearch(Request $request)
    {
        // 在籍生徒数を表示するための情報を取得
        $enrolledStudentCount = $this->countEnrolledStudents();
        // カレンダーの作成のための情報を取得
        [$prev, $next, $weeks, $html_title, $thismonth] = $this->createCalender();
        $param = [
            'date' => $request->date,
            'time' => $request->time,
            'statuses' => $this->statuses,
            'lesson_types' => $this->lesson_types,
            'prev' => $prev,
            'next' => $next,
            'weeks' => $weeks,
            'html_title' => $html_title,
            'thismonth' => $thismonth,
            'enrolledStudentCount' => $enrolledStudentCount
        ];
        return view('us.scheduleRegisterSearch', $param);
    }

    /**
     * スケジュール新規登録の生徒検索処理と結果の表示
     */
    public function scheduleRegisterSearchResult(Request $request)
    {
        // 生徒検索処理
        $students = DB::table('students')
            ->where('firstname', 'like', '%' . $request->firstname . '%')
            ->where('lastname', 'like', '%' . $request->lastname . '%')
            ->where('firstname_ruby', 'like', '%' . $request->firstname_ruby . '%')
            ->where('lastname_ruby', 'like', '%' . $request->lastname_ruby . '%')
            ->where('phonenumber', 'like', '%' . $request->phonenumber . '%')
            ->where('email', 'like', '%' . $request->email . '%')
            ->where('status', 'like', '%' . $request->status . '%')
            ->where('lesson_type', 'like', '%' . $request->lesson_type . '%')
            ->get();

        $instructors = Instructor::orderBy('created_at', 'asc')->get();

        // 在籍生徒数を表示するための情報を取得
        $enrolledStudentCount = $this->countEnrolledStudents();
        // カレンダーの作成のための情報を取得
        [$prev, $next, $weeks, $html_title, $thismonth] = $this->createCalender();
        $param = [
            'students' => $students,
            'instructors' => $instructors,
            'date' => $request->date,
            'time' => $request->time,
            'statuses' => $this->statuses,
            'lesson_types' => $this->lesson_types,
            'prev' => $prev,
            'next' => $next,
            'weeks' => $weeks,
            'html_title' => $html_title,
            'thismonth' => $thismonth,
            'enrolledStudentCount' => $enrolledStudentCount
        ];
        return view('us.scheduleRegisterSearchResult', $param);
    }

    /**
     * スケジュール新規登録画面の表示(生徒情報を入れた後)
     */
    public function scheduleCreateScreen($student_id, $date, $time)
    {
        $student = Student::find($student_id);
        $instructors = Instructor::orderBy('created_at', 'asc')->get();
        $lesson_times = $this->lesson_times;
        // 在籍生徒数を表示するための情報を取得
        $enrolledStudentCount = $this->countEnrolledStudents();
        // カレンダーの作成のための情報を取得
        [$prev, $next, $weeks, $html_title, $thismonth] = $this->createCalender();
        $param = [
            'student' => $student,
            'instructors' => $instructors,
            'date' => $date,
            'time' => $time,
            'lesson_times' => $lesson_times,
            'prev' => $prev,
            'next' => $next,
            'weeks' => $weeks,
            'html_title' => $html_title,
            'thismonth' => $thismonth,
            'enrolledStudentCount' => $enrolledStudentCount
        ];
        return view('us.scheduleCreate', $param);
    }

    /**
     * スケジュール新規登録処理
     */
    public function scheduleCreate(Request $request)
    {
        $student = Student::find($request->student_id);

        $date = $request->date;
        $ym = date('Y-m', strtotime($date));
        $j = date('j', strtotime($date));

        // リダイレクトするURL
        $url = "/schedules/basic/";
        $url .= $ym;
        $url .= "/";
        $url .= $j;

        // スケジュールの登録処理
        $schedule = new Schedule;
        $schedule->student_id = $request->student_id;
        $schedule->instructor_id = $request->instructor_id;
        $schedule->date = $request->date;
        $schedule->time = $request->time;
        $schedule->lesson_type = $student->lesson_type;
        $schedule->memo = $request->memo;
        $schedule->save();

        // 生徒のペアが設定されていた場合の処理
        if ($student->pair_id != -1) {
            $pairStudent = Student::find($student->pair_id);
            $pairschedule = new Schedule;
            $pairschedule->student_id = $pairStudent->id;
            $pairschedule->instructor_id = $pairStudent->instructor_id;
            $pairschedule->date = $request->date;
            $pairschedule->time = $request->time;
            $pairschedule->lesson_type = $pairStudent->lesson_type;
            $pairschedule->save();
        }
        return redirect($url);
    }

    /**
     * スケジュール更新画面
     */
    public function scheduleEditScreen($schedule_id)
    {
        $schedule = Schedule::find($schedule_id);
        $student = Student::find($schedule->student_id);
        $instructors = Instructor::orderBy('created_at', 'asc')->get();
        $lesson_times = $this->lesson_times;

        $date = $schedule->date;
        $ym = date('Y-m', strtotime($date));
        $j = date('j', strtotime($date));

        // 前のページへ戻るためのURL
        $url = "/schedules/basic/";
        $url .= $ym;
        $url .= "/";
        $url .= $j;
        // 在籍生徒数を表示するための情報を取得
        $enrolledStudentCount = $this->countEnrolledStudents();
        // カレンダーの作成のための情報を取得
        [$prev, $next, $weeks, $html_title, $thismonth] = $this->createCalender();
        $param = [
            'schedule' => $schedule,
            'student' => $student,
            'instructors' => $instructors,
            'lesson_times' => $lesson_times,
            'ym' => $ym,
            'j' => $j,
            'prev' => $prev,
            'next' => $next,
            'weeks' => $weeks,
            'html_title' => $html_title,
            'thismonth' => $thismonth,
            'enrolledStudentCount' => $enrolledStudentCount
        ];
        return view('us.scheduleEdit', $param);
    }

    /**
     * スケジュール更新処理
     */
    public function scheduleEdit(Request $request)
    {
        $date = $request->date;
        $ym = date('Y-m', strtotime($date));
        $j = date('j', strtotime($date));

        // リダイレクトするURL
        $url = "/schedules/basic/";
        $url .= $ym;
        $url .= "/";
        $url .= $j;

        $schedule = Schedule::find($request->schedule_id);

        // 生徒のペアが設定されていた場合の処理
        $student = Student::find($schedule->student_id);

        if ($student->pair_id != -1) {
            $pairStudent = Student::find($student->pair_id);

            // ペアの生徒のスケジュールを検索
            $pairStudentSchedule = DB::table('schedules')
                ->where('student_id', $pairStudent->id)
                ->where('date', $schedule->date)
                ->where('time', $schedule->time)
                ->first();

            $pairschedule = Schedule::find($pairStudentSchedule->id);
            $pairschedule->instructor_id = $request->instructor_id;
            $pairschedule->date = $request->date;
            $pairschedule->time = $request->time;
            $pairschedule->save();
        }

        // スケジュールの登録処理
        $schedule->instructor_id = $request->instructor_id;
        $schedule->date = $request->date;
        $schedule->time = $request->time;
        $schedule->memo = $request->memo;
        $schedule->save();
        return redirect($url);
    }

    /**
     * スケジュールの削除
     *
     * @param Request $request 削除したいスケジュールのidを保持
     * @return void
     */
    public function scheduleRemove(Request $request)
    {
        $date = $request->date;
        $ym = date('Y-m', strtotime($date));
        $j = date('j', strtotime($date));

        // リダイレクトするURL
        $url = "/schedules/basic/";
        $url .= $ym;
        $url .= "/";
        $url .= $j;

        $schedule = Schedule::find($request->schedule_id);
        // 生徒のペアが設定されていた場合の処理
        $student = Student::find($schedule->student_id);

        if ($student->pair_id != -1) {
            $pairStudent = Student::find($student->pair_id);

            // ペアの生徒のスケジュールを検索
            $pairStudentSchedule = DB::table('schedules')
                ->where('student_id', $pairStudent->id)
                ->where('date', $schedule->date)
                ->where('time', $schedule->time)
                ->first();

            $pairschedule = Schedule::find($pairStudentSchedule->id);
            DB::table('schedules')->where('id', $pairschedule->id)->delete();
        }

        DB::table('schedules')->where('id', $schedule->id)->delete();
        return redirect($url);
    }

    /**
     * 生徒ごとのスケジュールの詳細画面(新規登録からの遷移)
     */
    public function scheduleStudetDetail1(Request $request)
    {
        $student = Student::find($request->student_id);
        $personalInstructor = Instructor::find($student->instructor_id);
        $schedules = DB::table('schedules')->where('student_id', $student->id)->orderBy('date', 'desc')->get();
        $instructors = Instructor::orderBy('created_at', 'asc')->get();
        $date = $request->date;
        $time = $request->time;
        $param = [
            'student' => $student,
            'personalInstructor' => $personalInstructor,
            'instructors' => $instructors,
            'schedules' => $schedules,
            'date' => $date,
            'time' => $time
        ];
        return view('us.studentScheduleDetailShow1', $param);
    }

    /**
     * 生徒ごとのスケジュールの詳細画面(更新からの遷移)
     */
    public function scheduleStudetDetail2(Request $request)
    {
        $nowScheduleId = $request->schedule_id;
        $student = Student::find($request->student_id);
        $personalInstructor = Instructor::find($student->instructor_id);
        $schedules = DB::table('schedules')->where('student_id', $student->id)->orderBy('date', 'desc')->get();
        $instructors = Instructor::orderBy('created_at', 'asc')->get();
        $param = [
            'student' => $student,
            'personalInstructor' => $personalInstructor,
            'instructors' => $instructors,
            'schedules' => $schedules,
            'nowScheduleId' => $nowScheduleId
        ];
        return view('us.studentScheduleDetailShow2', $param);
    }

    /**
     * 指定した月の未予約生徒の表示
     */
    public function unreservedStudent(Request $request)
    {
        $yearMonth = $request->yearMonth;
        $instructors = Instructor::orderBy('created_at', 'asc')->get();

        // 送られた年と月に対応するスケジュールをすべて取得
        $schedules = DB::table('schedules')
            ->where('date', 'like', '%' . $yearMonth . '%')
            ->get();

        // studentsテーブルのステータスカラムが'入校'の生徒をすべて取得
        $students = DB::table('students')->where('status', '入校')->get();

        // 取得したスケジュールに含まれている生徒のIDを配列に格納
        $ids = [];
        foreach ($schedules as $schedule) {
            $ids[] = $schedule->student_id;
        }
        // 重複している生徒IDを削除
        $ids = array_unique($ids);

        // 引数で指定した生徒IDに一致しない生徒を取得
        $students = $students->whereNotIn('id', $ids);

        $param = [
            'students' => $students,
            'schedules' => $schedules,
            'instructors' => $instructors,
            'yearMonth' => $yearMonth,
            'beforeUrl' => $request->url
        ];
        return view('us.unreservedStudent', $param);
    }
}
