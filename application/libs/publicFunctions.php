<?php

// BEGIN: General Functions
function pre($data, $exit = false)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    if ($exit) exit();
}

function outputJson($data, $exit = false)
{
    header("Content-Type: application/json");
    echo json_encode($data);
    if ($exit) exit();
}

function cleanInt($d)
{
    if (!$d && $d != 0) return '';
    return filter_var($d, FILTER_SANITIZE_NUMBER_INT);
}

function cleanStr($d)
{
    if (!$d && $d != 0) return '';
    return filter_var($d, FILTER_SANITIZE_STRING);
}

function cleanXss($str)
{
    if (empty($str)) return $str;
    return preg_replace('#<script(.*?)>(.*?)</script>#is', '', $str);
}

function cleanFilename($str)
{
    $str = strtolower($str); # lower case everything
    $str = preg_replace("/[^a-z0-9.]+/i", " ", $str); # make alphanumeric (removes all other characters)
    $str = preg_replace("/[\s-]+/", " ", $str); # clean up multiple dashes or whitespaces 
    $str = preg_replace("/[\s_]/", "-", $str); # convert whitespaces and underscore to dash
    return $str;
}

function randStr($length, $prefix = '', $suffix = '')
{
    $token = '';
    $charlist = 'abcdefghijklmnopqrstuvwxyz';
    $charlist .= '0123456789';
    $max = strlen($charlist);
    for ($i = 0; $i < $length; $i++) {
        $token .= $charlist[crypto_rand_secure(0, $max - 1)];
    }
    return $prefix . $token . $suffix;
}
function randNum($length, $prefix = '', $suffix = '')
{
    $token = '';
    $charlist = '0123456789';
    $max = strlen($charlist);
    for ($i = 0; $i < $length; $i++) {
        $token .= $charlist[crypto_rand_secure(0, $max - 1)];
    }
    return $prefix . $token . $suffix;
}
function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min;
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}

function isPageRequest()
{
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

/*function datatblProcessorDefault($table, $primaryKey, $columns, $method = 0, $whereResult = null, $whereAll = null) {
	$sql_details = array(
		'user' => DB_USER,
		'pass' => DB_PASS,
		'db'   => DB_NAME,
		'host' => DB_HOST
	);
	require APP . 'libs/ssp.class.php';
	if ($method === 0)
		$d = SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns );
	else if ($method === 1)
		$d = SSP::complex( $_POST, $sql_details, $table, $primaryKey, $columns, $whereResult, $whereAll );

	echo json_encode($d);
}*/

function datatblProcessor($table, $primaryKey, $columns, $qry, $retType = 0, $groupBy = '')
{
    require APP . 'libs/ssp.class.php';

    $data = SSP::customQry($_POST, [
        'user' => DB_USER,
        'pass' => DB_PASS,
        'db' => DB_NAME,
        'host' => DB_HOST,
        'charset' => DB_CHARSET
    ], $table, $primaryKey, $columns, $qry, $groupBy);

    if ($retType === 1) {
        return $data;
    } else {
        echo json_encode($data);
    }
}
// END: General Functions

// BEGIN: System Functions
function sysPlugins($type)
{
    if ($type === 'datatable') {
        return [
            'css' => [
                'datatable/datatables.min',
                'datatable/Responsive-2.4.1/css/responsive.bootstrap5.min'
            ],
            'js' => [
                'datatable/datatables.min',
                'datatable/Responsive-2.4.1/js/responsive.bootstrap5.min',
            ]
        ];
    } else if ($type === 'datepicker') {
        return [
            'css' => [
                'bootstrap-datepicker/css/bootstrap-datepicker.min'
            ],
            'js' => [
                'bootstrap-datepicker/js/bootstrap-datepicker.min'
            ]
        ];
    } else if ($type === 'ckeditor') {
        return [
            'js' => [
                'ckeditor5-build-classic/build/ckeditor'
            ]
        ];
    } else if ($type === 'lightbox') {
        return [
            'css' => [
                'lightbox2-2.11.4/lightbox2-2.11.4/src/css/lightbox'
            ],
            'js' => [
                'lightbox2-2.11.4/lightbox2-2.11.4/src/js/lightbox'
            ]
        ];
    } else if ($type === 'grapick') {
        return [
            'css' => [
                'grapick-0.1.10/dist/grapick.min'
            ],
            'js' => [
                'grapick-0.1.10/dist/grapick.min'
            ]
        ];
    } else if ($type === 'grid-gallery') {
        return [
            'css' => [
                'grid-gallery/css/grid-gallery'
            ],
            'js' => [
                'grid-gallery/js/grid-gallery'
            ]
        ];
    } else if ($type === 'sweet-alert') {
        return [
            'js' => [
                'sweetalert/sweetalert2.all.min'
            ]
        ];
    } else if ($type === 'image-compressor') {
        return [
            'js' => [
                'image-compressor/browser-image-compression'
            ]
        ];
    } else if ($type === 'axios') {
        return [
            'js' => [
                'axios/axios.min'
            ]
        ];
    }
    return null;
}

function pageBreadcrumb($data)
{
    $r = '';
    if (empty($data)) return $r;
    foreach ($data as $v) {
        $label = (empty($v['icon']) ? '' : $v['icon'] . ' ') . $v['label'];
        $r .= '<li class="breadcrumb-item h3' .
            (empty($v['active']) ? '"' : ' text-dark active" aria-current="page"') .
            '>' .
            ((empty($v['url']) || !empty($v['active'])) ? $label : '<a href="' . $v['url'] . '">' . $label . '</a>') .
            '</li>';
    }
    return $r;
}

function getSysFingerprint()
{
    return sha1("%9d#!" . $_SERVER['HTTP_USER_AGENT'] . "cne" . $_SERVER['REMOTE_ADDR']);
}
// END: System Functions