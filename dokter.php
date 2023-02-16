<?php
include('./inc/DbConnector.php');

class rest_api
{

    protected $final_output;

    function getJsonPostContent()
    {
        $body = file_get_contents('php://input');

        // decode json to array
        $decoded = json_decode($body, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid parameter: Invalid JSON');
        }
        return $decoded;
    }

    function checkMethod($expectedMethod)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if (strtoupper($method) != strtoupper($expectedMethod)) {
            throw new Exception(sprintf('Expected \'%s\' request, got \'%s\' instead', $expectedMethod, $method));
        }
    }

    function renderResponse($response)
    {
        header("Content-type: application/json");
        $str = json_encode($response);
        echo $str;
    }
}

$rest_apis = new rest_api;

$result_all = array();
try {

    $rest_apis->checkMethod('POST');

    $db = new DbConnector();

    $sql = "SELECT @n := @n + 1 nomor, t.namadokter, COUNT(t.NO) as jumlahpasien
            FROM tablepasien t, (SELECT @n := 0) m
            GROUP BY t.namadokter
				";

    $res = $db->query($sql);

    $content = array();
    while ($arr_get_data = $db->fetchArray($res)) {
        $content[] = $arr_get_data;
    }

    $result_all['responseCode'] = "200";
    $result_all['responseDesc'] = "Sukses";
    $result_all['Data'] = $content;
    $rest_apis->renderResponse($result_all);
} catch (Exception $e) {
    $result_all['responseCode'] = "400";
    $result_all['responseDesc'] = $e->getMessage();
    $result_all['responseContent'] = "";
    $rest_apis->renderResponse($result_all);
}
