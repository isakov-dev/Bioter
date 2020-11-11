<?
require_once '../Logic.php';

switch ($_REQUEST['action']) {

    case 'send_form':
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data['phone'] && $data['name'])
            echo json_encode(Logic::SendForm($data));
        else
            http_response_code(400);
        break;

    default:

        http_response_code(400);

}