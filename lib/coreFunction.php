<?php
include('db.php');

    class CoreFunction extends Database {
        function setQuery ($sql)
        {
            $result = $this->conn->query($sql);
            if(!$result) {
                die('Query failed'.$this->conn->error);
            }
            return $result;
        }
        function getAll($sql)
        {
            $result=$this->setQuery($sql);
            $a=array();
            while ($row = $result->fetch_assoc()) {
                $a[]=$row;
            }
            return $a;
        }
        function getOne($sql){
            $result=$this->setQuery($sql);
            $a = $result->fetch_assoc();
            return $a;
        }
    
        
        function addRecord($table, $params = array())
        {
            $sql = "INSERT INTO " . $table . "("; // cau lenh chen them bang
            $txtKey = ""; // ten cot
            $txtValue = "";// ten gia tri cua cot
            $i = 0;
            foreach ($params as $key => $value) {
                if ($i <count($params)-1){
                    $txtKey .= " `" . $key ."`,";
                    $txtValue .= "'". $value. "',";
                }
                else{
                    $txtKey .= " `" .$key ."`";  
                    $txtValue .= "'". $value. "'";       
                }
                $i++;
            
        }
    
        $sql .= $txtKey;
        $sql .=") VALUES (";

        $sql .=$txtValue;
        $sql .=")";
        $this->setQuery($sql);
        return $this->conn->insert_id;
    }
    function editRecord($table, $id, $params= array()) {
        $txtSet ="";
        $i = 0;
        foreach($params as $key => $value) {
            if($i<count($params) -1)
            {
                $txtSet .= "$key = '$value', ";  // Đảm bảo các giá trị chuỗi có dấu nháy đơn

            }
            else
            {
                $txtSet .= "$key = '$value' ";  // Đảm bảo các giá trị chuỗi có dấu nháy đơn

            }
                $i++;

            }
            $sql = "UPDATE ". $table. " SET ". $txtSet. " WHERE id = ". $id;
    
            $this->setQuery($sql);
        }
        function delRecord($table, $id) {
            $sql = "DELETE FROM " . $table . " WHERE id = " . $id;
            $this->setQuery($sql);
        }
        function checkExist($table, $record, $value) {
            // Tạo câu truy vấn SQL để kiểm tra sự tồn tại của giá trị trong bảng
            $sql = "SELECT * FROM $table WHERE $record = '$value'";
        
            // Thực thi truy vấn và lấy kết quả
            $result = $this->getAll($sql);
        
            // Kiểm tra số lượng hàng trong kết quả
            if (count($result) > 0) {
                // Nếu có kết quả, nghĩa là giá trị đã tồn tại
                $message = "$value đã tồn tại";
                return $message;
            } else {
                // Nếu không có kết quả, nghĩa là giá trị chưa tồn tại
                return 1; // Bạn có thể thay đổi giá trị trả về tùy ý
            }
        }
        function message($txt) {
            $url = $_SERVER['REQUEST_URI'];
            $s = "<script>";
            $s .= "confirm('" . $txt . "');";
            $s .= "window.location = '" . $url . "';";
            $s .= "</script>";
            echo $s;
        }
        
}

?>