<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
class UplaodImage
{
    function upload_file($params){
        $data = array(
            'file_name'         => (isset($params['file_name']))    ? $params['file_name']  : 'newname',
            'path_name'         => (isset($params['path_name']))    ? $params['path_name']  : 'uploads',
            'allow_ext'         => (isset($params['allow_ext']))    ? $params['allow_ext']  : ['jpg', 'jpeg', 'gif','png'],
            'file_size'         => (isset($params['file_size']))    ? $params['file_size']  : 2000000,
            'redirect'          => (isset($params['redirect']))     ? $params['redirect']   : '',
            'msg'               => (isset($params['msg']))          ? $params['msg']        : 'message',
            'file_info'         => (isset($params['file_info']))    ? $params['file_info']  : 'file_info',
        );

       $is_dir_upload = '';
       $size = '';
       $files_name = '';
       $message = '';
       $file_ext = '';
       $redirect_to = '';
       $file_info = '';
       $info = false;
       if($data['path_name'] != ''){
           $is_dir_upload = $data['path_name'];
        }
       if($data['file_info'] != ''){
           $file_info = $data['file_info'];
        }
        if($data['file_size'] != ''){
            $size = $data['file_size'];
        }
        if($data['file_name'] != ''){
            $files_name = $data['file_name'];
        }
        if($data['allow_ext'] != ''){
            $file_ext = $data['allow_ext'];
        }
        if($data['msg'] != ''){
            $message = $data['msg'];
        }
        if($data['redirect'] != ''){
            $redirect_to = $data['redirect'];
        }
        if(!is_dir($is_dir_upload)){
            $this->create_dirname($is_dir_upload, 0755, true); // create folder uploads
        }
        $is_dir_year = $is_dir_upload.'/'.date('Y');
        if(!is_dir($is_dir_year)){
            $this->create_dirname($is_dir_year, 0755, true); // create folder year
        }
        $is_dir_day = $is_dir_year.'/'.date('d');
        if(!is_dir($is_dir_day)){
            $this->create_dirname($is_dir_day, 0755, true); // create folder day
        }
        $full_path = $is_dir_day;
        if(!is_dir($full_path)){
            $this->create_dirname($full_path, 0755, true); // create folder uploads/year/day
        }else{
            if(isset($_FILES['image'])){ // check if have file
                // exit();
                $image_size = $_FILES['image']['size']; // get file size
                $image_name = $_FILES['image']['name']; // get file name
                $file_to_string = explode('.', $image_name); // convert array file to string
                $extension = strtolower(end($file_to_string)); // get extension file
                $fileoldname = strtolower(reset($file_to_string)); // get extension file
                $random_number = rand(10,100);
                $new_name = $files_name.date('Ymdhis').'.'. $extension;
                $upload_path = $full_path.'/'.$new_name; // full path with file name
                $tmp_path = $_FILES["image"]["tmp_name"];
                if(array_intersect($file_ext,[$extension])){ // check file extension
                    if($image_size <= $size){ // check file size
                        $is_uploaded = move_uploaded_file($tmp_path, $upload_path);
                        if($is_uploaded){
                            $file_infos = [
                                $info['full_file_old_name'] = $image_name,
                                $info['file_size'] = $image_size,
                                $info['file_extension'] = $extension,
                                $info['file_old_name'] = $fileoldname,
                                $info['file_full_path'] = $upload_path,
                                $info['file_new_name'] = $new_name
                            ];
                            $this->set_flash_message($message, '<span style="color:green">Success!</span>');
                            if($redirect_to == ''){
                                return $file_infos;
                            }
                        }else{
                            $this->set_flash_message($message, '<span style="color:red">Upload failed</span>');
                       
                        }
                    }else{
                        $this->set_flash_message($message, '<span style="color:red">Max size '.$size .' Your file size '.$image_size.'</span>');
                    }

                }else{
                    $this->set_flash_message($message, '<span style="color:red">Allow file extension '.implode(', ', $file_ext).'</span>');
                }
           }
        }
    }

    function create_dirname($dir_Name, $perm = 0755, $status = true){
        $result = false;
        if(mkdir($dir_Name, $perm, $status)){
            $result = true;
        }
        return $result;
    }

    function list_dir($path_name){
  
        $dir_name = '';
        if($path_name != ''){
            $dir_name = $path_name;
        }
        if(file_exists($dir_name) && is_dir($dir_name)){
            $result = scandir($dir_name);
            $html = '';   
                $html .= '<table>';
                    $html .= '<thead>';
                        $html .= '<tr>';
                            $html .= '<th>No</th>';
                            $html .= '<th>Name</th>';
                            $html .= '<th>Type</th>';
                            $html .= '<th>Size</th>';
                        $html .= '</tr>';
                    $html .= '</thead>';
            $html .= '<tbody>';
            $i = 1;
            foreach($result as $file){
                if(!in_array($file, array('.','..'))){
                    if(is_file($dir_name.'/'.$file)){
                        $html .= '<tr>';
                            $html .= '<td>'.$i++.'</td>';
                            $html .= '<td>'.$file.'</td>';
                            $html .= '<td>File</td>';
                            $html .= '<td>'.filesize($dir_name.'/'.$file).' bytes </td>';
                        $html .= '</tr>';
                    }else{
                        $html .= '<tr>';
                            $html .= '<td>'.$i++.'</td>';
                            $html .= '<td>'.$file.'</td>';
                            $html .= '<td>Folder</td>';
                            $html .= '<td>'.filesize($dir_name.'/'.$file).' bytes </td>';
                        $html .= '</tr>';
                    }
                }
           }
               $html .= '</tbody>';
            $html .= '</table>';
            return $html;
        }
    }


    function rename_file($path_name, $old_name, $new_name){
        $result = false;
        $dir_name = '';
        $file_old_name = '';
        $file_new_name = '';
        if($path_name != ''){
            $dir_name = $path_name;
        }
        if($old_name != ''){
            $file_old_name = $old_name;
        }
        if($new_name != ''){
            $file_new_name = $new_name;
        }
        if(file_exists($dir_name.'/'.$file_old_name)){
            rename($dir_name.'/'.$file_old_name, $dir_name.'/'.$file_new_name);
        }else{
            echo "No such file or directory";
        }

    }

    function get_ip_address(){
        $ipaddress = getenv("REMOTE_ADDR");
        echo $ipaddress;
    }


    function set_flash_message($type, $message = "Hello World"){

        if(isset($type)){
           $_SESSION[$type] = $message;
        }
        return $message;
    }
 
    function get_flash_message($type){ // $message = 'success';
        $html = false;
        if(isset($_SESSION[$type]))
        {
            $html = $_SESSION[$type];
            unset($_SESSION[$type]);
        }
        return $html;
    }

    function redirect($filename){
        $file = '';
        if($filename != ''){
            $file = header("Location:".$filename);exit();
        }
        return $file;
    }
}