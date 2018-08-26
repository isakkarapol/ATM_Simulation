<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

require_once FCPATH . 'vendor/autoload.php';

class Api extends REST_Controller {

    function __construct() {
        // Construct our parent class
        parent::__construct();

        // Load Model
        $this->load->model("Atm_model", "atm");
    }

    public function banknote_avaliable_post() {

        $post = $this->input->post();
        $return = array(
            'meta' => array(
                'page' => 1
                , 'pages' => 1
                , 'perpage' => 100
                , 'total' => 0
                , 'sort' => "DESC"
                , 'field' => "Id"
            )
            , 'data' => array()
        );

        if (!empty($post['datatable'])):
            $return['meta']['page'] = +$post['datatable']['pagination']['page'];
            $return['meta']['perpage'] = +$post['datatable']['pagination']['perpage'];
        endif;

        if (!empty($post['datatable']['sort']['field']) && $post['datatable']['sort']['field'] != 'ReferenceNumber'):
            $return['meta']['field'] = $post['datatable']['sort']['field'];
            $return['meta']['sort'] = $post['datatable']['sort']['sort'];
        endif;
        $order_field = $return['meta']['field'];
        $order_method = $return['meta']['sort'];
        $order_by = array($order_field => $order_method);

        $where = array();
        $search = "";
        if (isset($post['datatable']['query']['generalSearch'])) {
            if (!empty($post['datatable']['query']['generalSearch'])) {
                $search = $post['datatable']['query']['generalSearch'];
            }
        }
        $result = $this->atm->get_banknote_avaliable();
        $return['meta']['total'] = count($result);
        $return['meta']['pages'] = ceil($return['meta']['total'] / ($return['meta']['perpage'] != -1 ? $return['meta']['perpage'] : $return['meta']['total']));
        $return['data'] = array_slice($result, $return['meta']['perpage'] * ($return['meta']['page'] - 1), $return['meta']['perpage'], TRUE);

        $return = json_encode($return);
        header('Content-Type: application/json');
        echo $return;
    }

    public function withdraw_post() {

        $post = $this->input->post();
        $return = array(
            'result' => true
            , 'message' => 'Please take your cash out of the machine.'
        );

        $check_all_cash = $this->check_all_cash($post['withdraw']);
        if (!$check_all_cash['result']):
            echo json_encode($check_all_cash);
            exit();
        endif;

        $check_avaliable_withdraw = $this->check_avaliable_withdraw($post['withdraw']);
        if (!$check_avaliable_withdraw['result']):
            echo json_encode($check_avaliable_withdraw);
            exit();
        endif;

        $calculate_banknote = $this->calculate_banknote($post['withdraw']);
//        p($calculate_banknote);
        if (!$calculate_banknote['result']):
            echo json_encode($calculate_banknote);
            exit();
        else:
            $return['message'] .= $calculate_banknote['message'];
            $this->completed_withdraw($calculate_banknote['banknote']);
            $this->log_withdraw($calculate_banknote['banknote']);
        endif;

        echo json_encode($return);
        exit();
    }

    private function check_all_cash($withdraw = 0) {
        $get_all_balance = $this->atm->get_all_balance()->balance;
        $return = array(
            'result' => true
            , 'message' => 'Success'
        );
        if (($get_all_balance < $withdraw)):
            $return['result'] = false;
            $return['message'] = "This machine doesn't have enough money for your request.";
        endif;
        return $return;
    }

    private function check_avaliable_withdraw($withdraw = 0) {
        $return = array(
            'result' => true
        );

        if ($withdraw <= 0 || $withdraw == ''):
            $return['result'] = false;
            $return['message'] = "You requested to withdaw nothing please check it again.";
        endif;

        return $return;
    }

    private function check_banknote_avaliable($banknote = NULL, $qty = NULL) {
        $return['result'] = true;
        $get_banknote_avaliable = $this->atm->get_banknote_avaliable($banknote);
        if ($qty > $get_banknote_avaliable->remain):
            $return['result'] = false;
            $return['message'] = "This machine doesn't have enough " . $get_banknote_avaliable->name . " note for your request.";
        endif;
        return $return;
    }

    private function calculate_banknote($withdraw = 0) {
        $notes = array(
            '1000' => 0
            , '500' => 0
            , '100' => 0
            , '50' => 0
            , '20' => 0
        );

        $two_digit = substr($withdraw, -2);
        if (($two_digit % 20) == 0):
            $tmp_check_notes = (int) ($two_digit / 20);
            $check_banknote_avaliable = $this->check_banknote_avaliable(20, $tmp_check_notes);
            if ($check_banknote_avaliable['result']):
                $notes['20'] += $tmp_check_notes;
                $tmp_mod = '20' * $notes['20'];
                $withdraw -= $two_digit;
            endif;
        endif;
        foreach ($notes as $key => $val):
            $tmp_check_notes = 0;
            $tmp_check_notes = (int) ($withdraw / $key);
            $check_banknote_avaliable = $this->check_banknote_avaliable($key, $tmp_check_notes);
            if ($check_banknote_avaliable['result']):
                $notes[$key] += $tmp_check_notes;
                $tmp_mod = $key * $tmp_check_notes;
                if ($tmp_mod != 0):
                    $withdraw %= $tmp_mod;
                endif;
            endif;
        endforeach;


        if ($withdraw == 0):
            $return = array(
                'result' => true
                , 'message' => ''
                , 'banknote' => $notes
            );
            foreach ($notes as $key => $val):
                if ($val != 0):
                    $return['message'] .= "<BR>" . $key . "฿ : $val note(s).";
                endif;
            endforeach;
        else:
            $return = array(
                'result' => false
                , 'message' => "This machine couldn't withdraw " . $withdraw . "฿"
            );
        endif;

        return $return;
    }

    private function completed_withdraw($notes = NULL) {
        $tmp_log = array();
        foreach ($notes as $key => $val):
            if ($val != 0):
                $this->db->set('withdraw', 'withdraw+' . $val, FALSE);
                $this->db->where('code', $key);
                $this->db->update('banknotes');
                $tmp_log[] = array(
                    'code' => $key
                    , 'withdraw' => $val
                );
            endif;
        endforeach;
        $insert_log = array(
            'datetime' => date($this->config->item('log_date_format'))
            , 'detail' => json_encode($tmp_log)
        );
        $this->db->insert('log_withdraw', $insert_log);
    }

    private function log_withdraw($notes = NULL) {
        $data = array(
            array(
                'title' => 'My title',
                'name' => 'My Name',
                'date' => 'My date'
            ),
            array(
                'title' => 'Another title',
                'name' => 'Another Name',
                'date' => 'Another date'
            )
        );
    }

    public function log_withdraw_post() {
        $post = $this->input->post();
        $return = array(
            'meta' => array(
                'page' => 1
                , 'pages' => 1
                , 'perpage' => 100
                , 'total' => 0
                , 'sort' => "DESC"
                , 'field' => "Id"
            )
            , 'data' => array()
        );

        if (!empty($post['datatable'])):
            $return['meta']['page'] = +$post['datatable']['pagination']['page'];
            $return['meta']['perpage'] = +$post['datatable']['pagination']['perpage'];
        endif;

        if (!empty($post['datatable']['sort']['field']) && $post['datatable']['sort']['field'] != 'ReferenceNumber'):
            $return['meta']['field'] = $post['datatable']['sort']['field'];
            $return['meta']['sort'] = $post['datatable']['sort']['sort'];
        endif;
        $order_field = $return['meta']['field'];
        $order_method = $return['meta']['sort'];
        $order_by = array($order_field => $order_method);

        $where = array();
        $search = "";
        if (isset($post['datatable']['query']['generalSearch'])) {
            if (!empty($post['datatable']['query']['generalSearch'])) {
                $search = $post['datatable']['query']['generalSearch'];
            }
        }
        $result = $this->atm->get_log_withdraw();
        $return['meta']['total'] = count($result);
        $return['meta']['pages'] = ceil($return['meta']['total'] / ($return['meta']['perpage'] != -1 ? $return['meta']['perpage'] : $return['meta']['total']));
        $return['data'] = array_slice($result, $return['meta']['perpage'] * ($return['meta']['page'] - 1), $return['meta']['perpage'], TRUE);

        $return = json_encode($return);
        header('Content-Type: application/json');
        echo $return;
    }

}
