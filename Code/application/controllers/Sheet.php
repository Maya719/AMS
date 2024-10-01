<?php defined('BASEPATH') or exit('No direct script access allowed');

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Drive;

class Sheet extends CI_Controller
{
    public $data = [];
    public $serviceAccountPath;
    public $client;
    public function __construct()
    {
        require_once APPPATH . '../vendor/autoload.php';
        parent::__construct();
        $this->serviceAccountPath = FCPATH . 'assets2/spreadsheet-436507-c0fb86ab5259.json';
        $this->client = new Client();
        $this->client->setAuthConfig($this->serviceAccountPath);
        $this->client->addScope(Sheets::SPREADSHEETS);
        $this->client->addScope(Drive::DRIVE);
    }
    
    public function index()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->is_admin() || permissions('reports_view')) && is_module_allowed('reports')) {

            $this->data['page_title'] = 'Attendance Report - ' . company_name();
            $saas_id = $this->session->userdata('saas_id');
            $this->db->where('saas_id', $saas_id);
            $query4 = $this->db->get('shift');
            $this->data['shifts'] = $query4->result_array();
            $this->db->where('saas_id', $saas_id);
            $query3 = $this->db->get('departments');
            $this->data['departments'] = $query3->result_array();
            $this->data['main_page'] = 'Attendance Report';
            $this->data['current_user'] = $this->ion_auth->user()->row();

            if ($this->ion_auth->is_admin() || is_all_users()) {
                $this->data['system_users'] = $this->ion_auth->members()->result();
            } elseif (is_assign_users()) {
                $selected = selected_users();
                foreach ($selected as $user_id) {
                    $users[] = $this->ion_auth->user($user_id)->row();
                }
                $users[] = $this->ion_auth->user($this->session->userdata('user_id'))->row();
                $this->data['system_users'] = $users;
            }
            $this->load->view('report-attendance', $this->data);
        } else {
            redirect_to_index();
        }
    }

    public function create()
    {
        $this->form_validation->set_rules('user_id', 'Sharing User', 'required');
        if ($this->form_validation->run() == TRUE) {
            $type = 'company_' . $this->session->userdata('saas_id');
            $this->db->select('value');
            $this->db->from('settings');
            $this->db->where(['type' => $type]);
            $query = $this->db->get();
            $data = $query->result_array();
            $data = json_decode($data[0]['value']);
            $company_name = $data->company_name;
            $email = $this->input->post('user_id');
            if ($data->sheet) {
                $sheet = $data->sheet;
                $this->shareSpreadsheet($sheet, $email);
            } else {
                $sheet = $this->registerCompany($company_name, $email);
                $data->sheet = $sheet;
                $updated_value = json_encode($data);
                $this->db->where('type', $type);
                $this->db->update('settings', ['value' => $updated_value]);
            }
            $sheets = $this->get_sheet_tabs($sheet);

            echo json_encode(array('error' => false, 'message' => 'Sheet updated and Shared.', 'sheets' => $sheets));
        } else {
            $this->data['error'] = true;
            $this->data['message'] = validation_errors();
            echo json_encode($this->data);
        }
    }

    protected function get_employee_details()
    {
        $saas_id = $this->session->userdata('saas_id');
        $finger_config = '1';
        $active = '1';
        $start_from = date('Y-01-01');
        $end_date = date('Y-m-d');
        $employees = $this->ion_auth->members()->result();
        $detail = [];

        // Initialize the first and second header rows
        $header1 = ['ID', 'Name', 'Joining Date', 'Job Period'];
        $header2 = ['', '', '', ''];

        // Dynamically fetch the leave types and build the headers
        $leave_types = $this->att_model->get_db_leave_types2(); // Fetch all leave types
        foreach ($leave_types as $leave_type) {
            $header1[] = $leave_type->name;      // Leave type name for the first header
            $header1[] = '';                     // Empty space for the first header row (spanning the next column)
            $header2[] = 'Allowed';              // "Allowed" for the second header
            $header2[] = 'Actual';               // "Actual" for the second header
        }

        // Adding additional columns to both header rows
        $header1 = array_merge($header1, ['Total Paid Leaves', 'Balance', 'Unpaid', 'Absents', 'Late Min']);
        $header2 = array_merge($header2, ['', '', '', '', '']);
        // Push both header rows into the detail array
        $detail[] = $header1;
        $detail[] = $header2;
        // Loop through employees and build the details for each one
        foreach ($employees as $employee) {
            if ($employee->active == $active && $employee->finger_config == $finger_config) {
                $employee_id = $employee->employee_id;
                $employee_leaves = [];
                $total_paid_consumed = 0;  // Sum of consumed paid leaves
                $total_remaining = 0;      // Sum of remaining leaves
                $unpaid_leaves = 0;        // Sum of unpaid leaves
                foreach ($leave_types as $leave_type) {
                    $paid_leaves = 0;
                    $leave_total = $this->att_model->get_total_of_leave_type_for_user($leave_type, $employee, $end_date);
                    // Fetch leaves for this employee and leave type
                    $leaves = $this->att_model->get_db_leaves($employee_id, $start_from, $end_date, $leave_type->id);
                    foreach ($leaves as $leave) {
                        $leaveDuration = (new DateTime($leave->ending_date))->diff(new DateTime($leave->starting_date))->days + 1;

                        if (strpos($leave->leave_duration, 'Full') !== false) {
                            if ($leave->paid == 0) {
                                $paid_leaves += $leaveDuration;
                            } else {
                                $unpaid_leaves += $leaveDuration;
                            }
                        } elseif (strpos($leave->leave_duration, 'Half') !== false) {
                            if ($leave->paid == 0) {
                                $paid_leaves += 0.5;
                            } else {
                                $unpaid_leaves += 0.5;
                            }
                        }
                    }

                    if ($leave_type->apply_on == 'all') {
                        $employee_leaves[] = $leave_total;
                    } elseif (($employee->gender == 'male' && $employee->martial_status == 'married') && $leave_type->apply_on == 'malemarried') {
                        $employee_leaves[] = $leave_total;
                    } elseif (($employee->gender == 'male' && $employee->martial_status == 'single') && $leave_type->apply_on == 'male') {
                        $employee_leaves[] = $leave_total;
                    } elseif (($employee->gender == 'female' && $employee->martial_status == 'married') && $leave_type->apply_on == 'femalemarried') {
                        $employee_leaves[] = $leave_total;
                    } elseif (($employee->gender == 'female' && $employee->martial_status == 'single') && $leave_type->apply_on == 'female') {
                        $employee_leaves[] = $leave_total;
                    } else {
                        $leave_total = 0;
                        $employee_leaves[] = 0;
                    }
                    // Add leave type total and consumed to employee_leaves array
                    $employee_leaves[] = $paid_leaves;     // Consumed paid leave count

                    // Update totals for the employee
                    $total_paid_consumed += $paid_leaves;
                    $total_remaining += $leave_total - $paid_leaves;
                }

                // Fetch attendance data
                $attendance = $this->att_model->get_attendance($employee_id, $start_from, $end_date);
                $late_min = $this->att_model->get_late_min($employee_id, $start_from, $end_date);
                $absents = $this->att_model->get_absents($employee_id, $start_from, $end_date, $attendance);

                // Construct the employee's detail row
                $detail[] = array_merge([
                    $employee_id,
                    $employee->first_name . ' ' . $employee->last_name,
                    $employee->join_date,
                    $this->user_duration($employee->join_date),
                ], $employee_leaves, [$total_paid_consumed], [$total_remaining], [$unpaid_leaves], [$absents], [$late_min]);
            }
        }
        return $detail;
    }

    protected function user_duration($join_date)
    {
        $current_date = new DateTime();
        $join_date = new DateTime($join_date);
        $interval = $current_date->diff($join_date);
        $years = $interval->y;
        $months = $interval->m;
        if ($years > 0 && $months > 0) {
            return "{$years} years, {$months} months";
        } elseif ($years > 0) {
            return "{$years} years";
        } elseif ($months > 0) {
            return "{$months} months";
        } else {
            return "Less than a month";
        }
    }
    protected function get_sheet_tabs($spreadsheetId)
    {
        $client = new Client();
        $client->setAuthConfig($this->serviceAccountPath);
        $client->addScope(Sheets::SPREADSHEETS);
        $client->addScope(Drive::DRIVE);
        $service = new Sheets($client);
        try {
            $response = $service->spreadsheets->get($spreadsheetId);
            $sheets = $response->getSheets();
        } catch (Google_Service_Exception $e) {
            return [];
        }

        $sheetExists = false;
        $sheetId = null;
        foreach ($sheets as $sheet) {
            $sheetTitle = $sheet->getProperties()->getTitle();
            if ($sheetTitle === 'Leaves') {
                $sheetExists = true;
                $sheetId = $sheet->getProperties()->getSheetId();
                break;
            }
        }

        if (!$sheetExists) {
            $sheetId = $this->add_sheet_tab($spreadsheetId, 'Leaves');
        }
        $values = $this->get_employee_details();
        $updateRange = 'Leaves!A1';
        $body = new Sheets\ValueRange([
            'values' => $values,
        ]);
        $params = [
            'valueInputOption' => 'RAW',
        ];

        $result = $service->spreadsheets_values->update($spreadsheetId, $updateRange, $body, $params);
        $requests = [
            [
                'repeatCell' => [
                    'range' => [
                        'sheetId' => $sheetId,
                        'startRowIndex' => 0,
                        'endRowIndex' => 1,
                        'startColumnIndex' => 0,
                        'endColumnIndex' => 19,
                    ],
                    'cell' => [
                        'userEnteredFormat' => [
                            'textFormat' => [
                                'bold' => true,
                            ],
                            'backgroundColor' => [
                                'red' => 66 / 255,
                                'green' => 133 / 255,
                                'blue' => 244 / 255,
                            ],
                        ],
                    ],
                    'fields' => 'userEnteredFormat.textFormat,userEnteredFormat.backgroundColor',
                ],
            ],
            [
                'repeatCell' => [
                    'range' => [
                        'sheetId' => $sheetId,
                        'startRowIndex' => 1,
                        'endRowIndex' => 2,
                        'startColumnIndex' => 0,
                        'endColumnIndex' => 19,
                    ],
                    'cell' => [
                        'userEnteredFormat' => [
                            'textFormat' => [
                                'bold' => true,
                            ],
                            'backgroundColor' => [
                                'red' => 66 / 255,
                                'green' => 133 / 255,
                                'blue' => 244 / 255,
                            ],
                        ],
                    ],
                    'fields' => 'userEnteredFormat.textFormat,userEnteredFormat.backgroundColor',
                ],
            ],
            [
                'repeatCell' => [
                    'range' => [
                        'sheetId' => $sheetId,
                        'startRowIndex' => 0,
                        'endRowIndex' => 1000,
                        'startColumnIndex' => 1,
                        'endColumnIndex' => 2,
                    ],
                    'cell' => [
                        'userEnteredFormat' => [
                            'textFormat' => [
                                'bold' => true,
                            ],
                        ],
                    ],
                    'fields' => 'userEnteredFormat.textFormat',
                ],
            ],
            [
                'repeatCell' => [
                    'range' => [
                        'sheetId' => $sheetId,
                        'startRowIndex' => 0,
                        'endRowIndex' => 1000,
                        'startColumnIndex' => 0,
                        'endColumnIndex' => 1,
                    ],
                    'cell' => [
                        'userEnteredFormat' => [
                            'textFormat' => [
                                'bold' => true,
                            ],
                        ],
                    ],
                    'fields' => 'userEnteredFormat.textFormat',
                ],
            ],
        ];
        $batchUpdateRequest = new Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => $requests,
        ]);
        $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
        return $result;
    }


    protected function add_sheet_tab($spreadsheetId, $newSheetTitle)
    {
        $client = new Client();
        $client->setAuthConfig($this->serviceAccountPath);
        $client->addScope(Sheets::SPREADSHEETS);
        $client->addScope(Drive::DRIVE);
        $service = new Sheets($client);

        try {
            $requestBody = new Sheets\BatchUpdateSpreadsheetRequest([
                'requests' => [
                    'addSheet' => [
                        'properties' => [
                            'title' => $newSheetTitle
                        ]
                    ]
                ]
            ]);

            $response = $service->spreadsheets->batchUpdate($spreadsheetId, $requestBody);
        } catch (Google_Service_Exception $e) {
            return null;
        }

        return $response;
    }

    protected function get_share_email($user_id)
    {
        $user = $this->ion_auth->user($user_id)->row()->email;
        return $user;
    }
    protected function registerCompany($companyName, $email)
    {
        // Create spreadsheet
        $spreadsheetId = $this->createCompanySpreadsheet($companyName);
        $this->shareSpreadsheet($spreadsheetId, $email);
        return $spreadsheetId;
    }
    protected function shareSpreadsheet($spreadsheetId, $emailToShare)
    {
        $client = new Client();
        $client->setAuthConfig($this->serviceAccountPath);
        $client->addScope(Drive::DRIVE);

        $driveService = new Drive($client);
        $permission = new Drive\Permission([
            'type' => 'user',
            'role' => 'writer',
            'emailAddress' => $emailToShare,
        ]);

        $driveService->permissions->create($spreadsheetId, $permission);
    }
    protected function createCompanySpreadsheet($companyName)
    {
        $client = new Client();
        $client->setAuthConfig($this->serviceAccountPath);
        $client->addScope(Sheets::SPREADSHEETS);
        $client->addScope(Drive::DRIVE);

        $sheetsService = new Sheets($client);

        // Create a new spreadsheet
        $spreadsheet = new Sheets\Spreadsheet([
            'properties' => [
                'title' => $companyName . ' Data Sheet',
            ],
        ]);

        $spreadsheet = $sheetsService->spreadsheets->create($spreadsheet);
        return $spreadsheet->spreadsheetId;
    }
}
