<?php

class CkImageUpload extends Controller
{
    function __construct($urlDetails)
    {
        parent::__construct($urlDetails);
    }

    public function uploadImage()
    {
        $upload_dir = 'file/ck-uploads/';
        $imgset = [
            'maxsize' => 5000, // in KB
            'maxwidth' => 5000,
            'maxheight' => 5000,
            'minwidth' => 10,
            'minheight' => 10,
            'type' => ['bmp', 'gif', 'jpg', 'jpeg', 'png', 'blob'],
        ];
    
        define('RENAME_F', 1);
    
        function setFName($p, $fn, $ex, $i)
        {
            if (RENAME_F == 1 && file_exists($p . $fn . $ex)) {
                return setFName($p, F_NAME . '_' . ($i + 1), $ex, ($i + 1));
            } else {
                return $fn . $ex;
            }
        }
    
        // Function to generate unique name
        function generateUniqueName($filename)
        {
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $basename = pathinfo($filename, PATHINFO_FILENAME);
            $uniqueId = uniqid();
            $currentTimestamp = time();
            $uniqueName = $uniqueId . '_' . $currentTimestamp . '_' . $basename . '.' . $extension;
            return $uniqueName;
        }
    
        $fileName = $_POST['fileName'] ?? '';
        $chunkIndex = $_POST['chunkIndex'] ?? null;
        $totalChunks = $_POST['totalChunks'] ?? null;
    
        // Handle Chunk Upload
        if ($chunkIndex !== null && $totalChunks !== null) {
            $tempFilePath = $upload_dir . $fileName . ".part";
            $finalFilePath = $upload_dir . $fileName;
    
            $chunk = file_get_contents($_FILES['upload']['tmp_name']);
            file_put_contents($tempFilePath, $chunk, FILE_APPEND);
    
            if ((int)$chunkIndex === (int)$totalChunks - 1) {
                // Generate a unique file name
                $uniqueFileName = generateUniqueName($fileName);
                $uniqueFilePath = $upload_dir . $uniqueFileName;
    
                // Rename the assembled file
                rename($tempFilePath, $uniqueFilePath);
    
                echo json_encode([
                    'url' => URL . $uniqueFilePath,
                    'message' => 'File successfully uploaded and assembled.',
                ]);
            } else {
                echo json_encode([
                    'status' => 'success',
                    'message' => "Chunk $chunkIndex uploaded successfully.",
                ]);
            }
            return;
        }
    
        // Handle Standard Upload
        if (isset($_FILES['upload']) && strlen($_FILES['upload']['name']) > 1) {
            define('F_NAME', preg_replace('/\.(.+?)$/i', '', basename($_FILES['upload']['name'])));
    
            $sepext = explode('.', strtolower($_FILES['upload']['name']));
            $type = end($sepext);
    
            if (!in_array($type, $imgset['type'])) {
                echo json_encode([
                    'error' => "The file: {$_FILES['upload']['name']} has an invalid extension.",
                ]);
                return;
            }
    
            list($width, $height) = getimagesize($_FILES['upload']['tmp_name']);
            if (isset($width) && isset($height)) {
                if ($width > $imgset['maxwidth'] || $height > $imgset['maxheight']) {
                    echo json_encode([
                        'error' => "Width x Height = $width x $height exceeds the maximum allowed size of {$imgset['maxwidth']} x {$imgset['maxheight']}.",
                    ]);
                    return;
                }
    
                if ($width < $imgset['minwidth'] || $height < $imgset['minheight']) {
                    echo json_encode([
                        'error' => "Width x Height = $width x $height is below the minimum allowed size of {$imgset['minwidth']} x {$imgset['minheight']}.",
                    ]);
                    return;
                }
    
                if ($_FILES['upload']['size'] > $imgset['maxsize'] * 1000) {
                    echo json_encode([
                        'error' => "Maximum file size must be {$imgset['maxsize']} KB.",
                    ]);
                    return;
                }
            }
    
            // Generate a unique file name
            $f_name = generateUniqueName($_FILES['upload']['name']);
            $uploadpath = $upload_dir . $f_name;
    
            if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadpath)) {
                echo json_encode([
                    'url' => URL . $uploadpath,
                    'message' => F_NAME . '.' . $type . ' successfully uploaded!',
                ]);
            } else {
                echo json_encode([
                    'error' => 'Unable to upload the file!',
                ]);
            }
        } else {
            echo json_encode([
                'error' => 'No file uploaded.',
            ]);
        }
    }
}
