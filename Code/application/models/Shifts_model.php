<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shifts_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Retrieve the latest shift record for a specific shift ID up to a given date.
     *
     * This function queries the `shift_logs` table to fetch shift records associated with
     * the provided shift ID. It filters the records to include only those created on or 
     * before the specified date. The results are ordered by the creation date in descending
     * order, ensuring that the most recent shift record is returned.
     *
     * If no date is provided, the current date is used as the default. The function then
     * retrieves the latest shift record based on the provided shift ID and date criteria.
     *
     * @param int $shift_id The ID of the shift to retrieve records for.
     * @param string $date The date up to which to retrieve shift records, in 'Y-m-d' format.
     *                      Defaults to the current date if not provided.
     * @return array|null Returns an associative array representing the latest shift record
     *                     for the given shift ID up to the specified date, or null if no record is found.
     */
    public function get_shifts_by_id($shift_id, $date = '')
    {
        if (empty($date)) {
            $date = date('Y-m-d');
        }
        $this->db->where('shift_id', $shift_id);
        $this->db->where('created <=', $date);
        $this->db->order_by('created', 'DESC');
        $query = $this->db->get('shift_logs');
        $shift = $query->row_array();
        return $shift;
    }

    /**
     * Retrieve the shift details for a specific user based on their employee ID.
     *
     * This function first converts the provided employee ID to a user ID using the 
     * `get_user_id_from_employee_id` function. It then retrieves the shift ID associated 
     * with the user using the `ion_auth` library. The shift ID is used to query the `shift`
     * table for shift details, filtered by the current SaaS ID (from session data).
     *
     * The function returns an object representing the shift details for the specified user.
     *
     * @param int|string $user_id The employee ID of the user for whom to retrieve shift details.
     * @return object|null Returns an object containing the shift details for the user, 
     *                     or null if no shift is found.
     */

    public function get_user_shift($user_id)
    {
        $user_id = get_user_id_from_employee_id($user_id);
        $shift_id = $this->ion_auth->user($user_id)->row()->shift_id;
        $this->db->where('saas_id', $this->session->userdata('saas_id'));
        $this->db->where('id', $shift_id);
        $query = $this->db->get('shift');
        $shift = $query->row();
        return $shift;
    }
}
