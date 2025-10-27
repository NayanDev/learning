<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\TrainingNewParticipant;
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

        $permissions = (new Constant())->permissionByMenu($this->generalUri);
        $data['permissions'] = $permissions;
        $data['more_actions'] = $moreActions;
        $data['table_headers'] = $this->tableHeaders;
        $data['title'] = $this->title;
        $data['uri_key'] = $this->generalUri;
        $data['uri_list_api'] = route($this->generalUri . '.listapi') . "?event_id=" . request('event_id');
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

        $layout = 'easyadmin::backend.idev.list_drawer';

        if (!request('event_id')) {
            $layout = 'easyadmin::backend.idev.list_drawer_with_checkbox';
        }


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
                $query->where('test_employee_id', $testEmployeeId);
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
        DB::beginTransaction();
        
        try {
            $userAnswers = $request->input('answers'); // array of answer_ids
            $testEmployeeId = $request->input('test_employee_id');
            $eventId = $request->input('event_id');
            $namaLengkap = $request->input('nama_lengkap');
            $email = $request->input('email');
            $posisi = $request->input('posisi');

            // Calculate total score
            $totalScore = 0;
            if ($userAnswers && is_array($userAnswers)) {
                foreach ($userAnswers as $answerId) {
                    $answer = Answer::find($answerId);
                    if ($answer) {
                        $totalScore += $answer->point;
                    }
                }
            }

            // Save to training_new_participants table
            $participant = new TrainingNewParticipant();
            $participant->test_employee_id = $testEmployeeId;
            $participant->name = $namaLengkap;
            $participant->email = $email;
            $participant->position = $posisi;
            $participant->score = $totalScore;
            $participant->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Test berhasil diselesaikan!',
                'score' => $totalScore,
                'total_answers' => count($userAnswers ?? []),
                'participant_id' => $participant->id
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
