<?php

class Atm_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_banknote_avaliable($banknote = NULL) {
        $error = FALSE;
        try {
            $this->db->select(array(
                'name'
                , '(deposit - withdraw) AS remain'
            ));
            if (!is_null($banknote)):
                $this->db->where(array(
                    'code' => $banknote
                ));
            endif;
            $query = $this->db->get('banknotes');

            if (!$query) {
                throw new Exception('Invalid params, please contact administrator');
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        if ($error) {
            return $error;
        } else {
            $rs = is_null($banknote) ? $query->result() : $query->row();
            return $rs;
        }
    }

    public function get_all_balance() {

        $error = FALSE;
        try {
            $this->db->select(array(
                'sum(code * (deposit - withdraw)) as balance'
            ));
            $query = $this->db->get('banknotes');

            if (!$query) {
                throw new Exception('Invalid params, please contact administrator');
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        if ($error) {
            return $error;
        } else {
            $rs = $query->row();
            return $rs;
        }
    }

    public function get_log_withdraw() {
        $error = FALSE;
        try {
            $this->db->select(array(
                '*'
            ));
            $this->db->order_by('id', 'DESC');
            $query = $this->db->get('log_withdraw');

            if (!$query) {
                throw new Exception('Invalid params, please contact administrator');
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        if ($error) {
            return $error;
        } else {
            $rs = $query->result();
//            p($rs);

            foreach ($rs as $key => $val):
                $json_decode = json_decode($val->detail);
                $return_detail = '';
                foreach ($json_decode as $key1 => $val1):
                    $return_detail .= "$val1->code = $val1->withdraw <BR>";
                endforeach;
//                p($return_detail);
                $rs[$key]->detail = $return_detail;
            endforeach;
//            exit();
            return $rs;
        }
    }

}
