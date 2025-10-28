<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\EventAnswer;
use App\Models\Question;
use App\Models\ResultQuestion;
use App\Models\TrainingNewParticipant;
use App\Models\UserAnswer;
use Exception;
use Idev\EasyAdmin\app\Helpers\Constant;
use Idev\EasyAdmin\app\Helpers\Validation;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QuestionController extends DefaultController
{
    protected $modelClass = Question::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Question';
        $this->generalUri = 'question';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
            ['name' => 'No', 'column' => '#', 'order' => true],
            ['name' => 'Event id', 'column' => 'event_id', 'order' => true],
            ['name' => 'Test employee id', 'column' => 'test_employee_id', 'order' => true],
            ['name' => 'Question text', 'column' => 'question_text', 'order' => true],
            ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
            ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [
            'primaryKeys' => ['event_id'],
            'headers' => [
                ['name' => 'Event id', 'column' => 'event_id'],
                ['name' => 'Test employee id', 'column' => 'test_employee_id'],
                ['name' => 'Question text', 'column' => 'question_text'],
            ]
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $fields = [
            [
                'type' => 'textarea',
                'label' => 'Question text',
                'name' =>  'question_text',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('question_text', $id),
                'value' => (isset($edit)) ? $edit->question_text : ''
            ],
            [
                'type' => 'hidden',
                'label' => 'Event id',
                'name' =>  'event_id',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('event_id', $id),
                'value' => (isset($edit)) ? $edit->event_id : request('event_id')
            ],
            [
                'type' => 'hidden',
                'label' => 'Test employee id',
                'name' =>  'test_employee_id',
                'class' => 'col-md-12 my-2',
                'required' => $this->flagRules('test_employee_id', $id),
                'value' => (isset($edit)) ? $edit->test_employee_id : request('test_employee_id')
            ],
        ];

        for ($i = 1; $i <= 4; $i++) {
            $arrAnswer = [
                'type' => 'text',
                'label' => 'Opsi ' . $i,
                'name' => 'answers[' . $i . ']',
                'class' => 'col-md-10 my-2',
                'value' => '',
                'required' => true,
            ];
            $arrPoint = [
                'type' => 'number',
                'label' => 'Poin',
                'name' => 'points[' . $i . ']',
                'class' => 'col-md-2 my-2',
                'value' => 0,
                'required' => true,
            ];

            $fields[] = $arrAnswer;
            $fields[] = $arrPoint;
        }

        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [];

        return $rules;
    }

    protected function defaultDataQuery()
    {
        $filters = [];
        $orThose = null;
        $orderBy = 'id';
        $orderState = 'DESC';
        if (request('search')) {
            $orThose = request('search');
        }
        if (request('order')) {
            $orderBy = request('order');
            $orderState = request('order_state');
        }
        if (request('test_employee_id')) {
            $filters[] = ['test_employee_id', '=', request('test_employee_id')];
        }
        if (request('event_id')) {
            $filters[] = ['event_id', '=', request('event_id')];
        }

        $dataQueries = $this->modelClass::where($filters)
            ->where(function ($query) use ($orThose) {
                $efc = ['#', 'created_at', 'updated_at', 'id'];

                foreach ($this->tableHeaders as $key => $th) {
                    if (array_key_exists('search', $th) && $th['search'] == false) {
                        $efc[] = $th['column'];
                    }
                    if (!in_array($th['column'], $efc)) {
                        if ($key == 0) {
                            $query->where($th['column'], 'LIKE', '%' . $orThose . '%');
                        } else {
                            $query->orWhere($th['column'], 'LIKE', '%' . $orThose . '%');
                        }
                    }
                }
            })
            ->orderBy($orderBy, $orderState);

        return $dataQueries;
    }

    public function store(Request $request)
    {
        $rules = $this->rules();
        $content = $request->content;
        // $type = $request->type;
        $answers = $request->answers;
        $points = $request->points;

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messageErrors = (new Validation)->modify($validator, $rules);

            return response()->json([
                'status' => false,
                'alert' => 'danger',
                'message' => 'Required Form',
                'validation_errors' => $messageErrors,
            ], 200);
        }

        DB::beginTransaction();

        try {
            $insert = new Question();
            $insert->question_text = $request->question_text;
            $insert->test_employee_id = $request->test_employee_id;
            $insert->event_id = $request->event_id;
            $insert->save();

            foreach ($answers as $key => $answer) {
                $insertAnsw = new Answer();
                $insertAnsw->content = $answer;
                $insertAnsw->point = $points[$key];
                $insertAnsw->question_id = $insert->id;
                $insertAnsw->save();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'alert' => 'success',
                'message' => 'Data Was Created Successfully',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        $moreActions = [
            [
                'key' => 'import-excel-default',
                'name' => 'Import Excel',
                'html_button' => "<button id='import-excel' type='button' class='btn btn-sm btn-info radius-6' href='#' data-bs-toggle='modal' data-bs-target='#modalImportDefault' title='Import Excel' ><i class='ti ti-upload'></i></button>"
            ],
            [
                'key' => 'export-excel-default',
                'name' => 'Export Excel',
                'html_button' => "<a id='export-excel' class='btn btn-sm btn-success radius-6' target='_blank' href='" . url($this->generalUri . '-export-excel-default') . "'  title='Export Excel'><i class='ti ti-cloud-download'></i></a>"
            ],
            [
                'key' => 'export-pdf-default',
                'name' => 'Export Pdf',
                'html_button' => "<a id='export-pdf' class='btn btn-sm btn-danger radius-6' target='_blank' href='" . url($this->generalUri . '-export-pdf-default') . "' title='Export PDF'><i class='ti ti-file'></i></a>"
            ],
        ];

        $params = "";
        if (request('test_employee_id')) {
            $params = "?test_employee_id=" . request('test_employee_id');
        }

        if (request('event_id')) {
            $params = "?event_id=" . request('event_id');
        }

        $permissions = (new Constant())->permissionByMenu($this->generalUri);
        $data['permissions'] = $permissions;
        $data['more_actions'] = $moreActions;
        $data['table_headers'] = $this->tableHeaders;
        $data['title'] = $this->title;
        $data['uri_key'] = $this->generalUri;
        $data['uri_list_api'] = route($this->generalUri . '.listapi') . $params;
        $data['uri_create'] = route($this->generalUri . '.create');
        $data['url_store'] = route($this->generalUri . '.store') . "?event_id=" . request('event_id');
        $data['fields'] = $this->fields();
        $data['edit_fields'] = $this->fields();
        $data['actionButtonViews'] = [
            'easyadmin::backend.idev.buttons.delete',
            'easyadmin::backend.idev.buttons.edit',
            'easyadmin::backend.idev.buttons.show',
            'easyadmin::backend.idev.buttons.import_default',
        ];
        $data['templateImportExcel'] = "#";
        $data['filters'] = request('event_id') ? [] : $this->filters();
        $data['drawerExtraClass'] = 'w-50';

        $layout = 'backend.idev.list_drawer_question';

        // if (!request('event_id')) {
        //     $layout = 'easyadmin::backend.idev.list_drawer_with_checkbox';
        // }


        return view($layout, $data);
    }

    public function getQuestionsForTest(Request $request)
    {
        try {
            $testEmployeeId = $request->query('test_employee_id');
            $eventId = $request->query('event_id');

            // Get questions with their answers
            $query = Question::with(['answers' => function ($q) {
                $q->orderBy('id', 'asc');
            }]);

            if ($testEmployeeId) {
                $query->where('event_id', $testEmployeeId);
            }

            // if ($eventId) {
            //     $query->where('event_id', $eventId);
            // }

            $questions = $query->orderBy('id', 'asc')->get();

            // Format the response
            $formattedQuestions = $questions->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question_text' => $question->question_text,
                    'answers' => $question->answers->map(function ($answer) {
                        return [
                            'id' => $answer->id,
                            'content' => $answer->content,
                            'point' => $answer->point
                        ];
                    })
                ];
            });

            return response()->json([
                'status' => true,
                'questions' => $formattedQuestions
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function submitTest(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'test_employee_id' => 'required|integer',
            'event_id' => 'nullable|integer',
            'test_type' => 'required|in:pre_test,post_test',
            'user_id' => 'required|integer|exists:users,id',
            'nama_lengkap' => 'required|string',
            'email' => 'required|email',
            'posisi' => 'nullable|string',
            'nik' => 'nullable|string',
            'answers' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $userAnswers = $request->input('answers'); // array of answer_ids indexed by question index
            $testEmployeeId = $request->input('test_employee_id');
            $eventId = $request->input('event_id');
            $testType = $request->input('test_type'); // pre_test atau post_test
            $userId = $request->input('user_id'); // ID user yang login
            $namaLengkap = $request->input('nama_lengkap');
            $email = $request->input('email');
            $posisi = $request->input('posisi');
            $nik = $request->input('nik');

            // Calculate total score and save detail answers to event_answers table
            $totalScore = 0;
            $answeredCount = 0;
            
            if ($userAnswers && is_array($userAnswers)) {
                foreach ($userAnswers as $questionIndex => $answerId) {
                    if ($answerId) {
                        $answer = Answer::find($answerId);
                        if ($answer) {
                            $totalScore += $answer->point;
                            $answeredCount++;

                            // Save detail answer to event_answers table
                            EventAnswer::create([
                                'user_id' => $userId,
                                'question_id' => $answer->question_id,
                                'answer_id' => $answer->id,
                                'point' => $answer->point
                            ]);
                        }
                    }
                }
            }

            // Save result to result_questions table (summary)
            // Simpan meskipun event_id null karena field nullable
            ResultQuestion::create([
                'event_id' => $eventId, // Bisa null sesuai migration
                'user_id' => $userId,
                'type' => $testType, // pre_test atau post_test
                'score' => $totalScore
            ]);

            // Save to training_new_participants table (untuk backward compatibility)
            $participant = new TrainingNewParticipant();
            $participant->test_employee_id = $testEmployeeId;
            $participant->type = $testType;
            $participant->name = $namaLengkap;
            $participant->email = $email;
            $participant->position = $posisi;
            $participant->score = $totalScore;
            $participant->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Test berhasil diselesaikan!',
                'data' => [
                    'score' => $totalScore,
                    'total_answers' => $answeredCount,
                    'participant_id' => $participant->id,
                    'test_type' => $testType,
                    'user_id' => $userId
                ]
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
                'error_detail' => $e->getTrace()
            ], 500);
        }
    }
}
