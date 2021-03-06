<?php

class Transaction_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function insert_new_transaction($tx_id, $user_id, $tx_type, $int_amount, $crypto_type, $to_address, $from_address = '', $comment, $log_id) {
        $this->db->insert('transactions', array(
            'tx_id' => $tx_id,
            'user_id' => $user_id,
            'transaction_type' => $tx_type,
            'crypto_amount' => $int_amount,
            'crypto_type' => $crypto_type,
            'address_to' => $to_address,
            'account_to' => $to_address,
            'address_from' => $from_address,
            'account_from' => $from_address,
            'messagetext' => $comment,
            'log_id' => $log_id
        ));
        return $this->db->insert_id();
    }

    /**
     * Because PHP does not support function overloading we have to make a separate function
     */
    public function insert_new_transaction_from_callback($tx_id, $user_id, $method, $tx_type, $int_amount, $crypto_type, $address_to, $address_from,
            $confirmations, $bitcoind_tx_info, $block_hash, $block_index, $block_time, $time, $time_received, $category, $account_name, $int_new_balance, $log_id)
    {
        $this->db->insert('transactions', array(
            'tx_id' => $tx_id,
            'user_id' => $user_id,
            'method' => $method,
            'transaction_type' => $tx_type,
            'crypto_amount' => $int_amount,
            'crypto_type' => $crypto_type,
            'address_to' => $address_to,
            'address_from' => $address_from,
            'confirmations' => $confirmations,
            'response' => $bitcoind_tx_info,
            'block_hash' => $block_hash,
            'block_index' => $block_index,
            'block_time' => $block_index,
            'tx_time' => $time,
            'tx_timereceived' => $time_received,
            'tx_category' => $category,
            'address_account' => $account_name,
            'crypto_balancecurrent' => $int_new_balance,
            'log_id' => $log_id
        ));
        return $this->db->insert_id();
    }

    public function update_tx_confirmations($id, $confirmations) {
        $this->db->update('transactions', array('confirmations' => $confirmations), array('id' => $id));
    }

    public function update_tx_on_app_callback($id, $response_callback, $full_callback_url, $callback_status) {
        $this->db->update('transactions', array(
            'response_callback' => $response_callback,
            'callback_url' => $full_callback_url,
            'callback_status' => $callback_status
        ), array('id' => $id));
    }

    public function get_transaction_by_id($id) {
        $query = $this->db->get_where('transactions', array('id' => $id), 1);
        return $query->row();
    }

}