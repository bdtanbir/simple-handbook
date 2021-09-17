<?php 
namespace Simple_Handbook;

class Shb_ajax {

    public function __construct() {
        add_filter('heartbeat_received', [$this, 'shb_receive_heartbeat'], 10, 2);
    }

    public function shb_receive_heartbeat(array $response, array $data) {
        if (empty($data['shb_customfield'])) {
            return $response;
        }

        $received_data = $data['shb_customfield'];

        $response['shb_customfield_hashed'] = sha1( $received_data);
        return $response;
    }
    
}