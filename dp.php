



<?php
class database{
private $conn;
function createDbConnection(){
    try{
        $this->conn = new mysqli("localhost","root","","student");
    }catch (Exception $error){
        echo $error->getMessage();
    
    }}

    function insertNewStudent($name,$email,$image){
      try{
          $current_date = date('Y-m-d H:i:s');
          $file_link = $this->saveImage($image);
          $sql = "INSERT INTO students (name,email,image,created_at)VALUES ('$name','$email','$file_link','$current_date')";
          $result =  $this->conn->query($sql);
          if($result==true){
              $this->createResponse(true,
                  $this->createStudentResponse($this->conn->insert_id,
                      $name,
                  $email,
                      $file_link,
                      $current_date
                      )
                 ,$current_date );
              }else{
              $this->createResponse(false,"data has not been inserted","");

          }

      }catch (Exception $error){
          $this->createResponse(false,$error->getMessage(),"");


      }
    }
    function getAllStudents(){
     try{
         $sql = "select * from students";
         $result = $this->conn->query($sql);

         $count =  $result->num_rows;
         if($count >0){
             $all_students_array = array();
             while ($row = $result->fetch_assoc()){
                 $id = $row["id"];
                 $name = $row["name"];
                 $email = $row["email"];
                 $image = $row["image"];
                 $date = $row["created_at"];
                 // create associative array for the student
                 $student_array = $this->createStudentResponse($id,$name,$email,$image,$date);
                 array_push($all_students_array,$student_array);
             }
             $this->createResponse(true,$count,$all_students_array);
         }
         else{
         //  throw  Exception("No Data Found");
         }
     }catch (Exception $exception){
         $this->createResponse(false,0,array("error"=>$exception->getMessage()));
     }


    }
    function getStudentById($id){
        $sql = "select * from students where id = $id";
        $result = $this->conn->query($sql);
        try{
            if($result->num_rows ==0){
                throw new Exception("there are no students with the passed id");
            }
            else{
                $row =   $result->fetch_assoc();
                $id = $row["id"];
                $name = $row["name"];
                $email = $row["email"];
                $image = $row["image"];
                $date = $row["created_at"];
                // create associative array for the student
                $student_array = $this->createStudentResponse($id,$name,$email,$image,$date);
                $this->createResponse(true,1,$student_array);

            }
        }
        catch (Exception $exception){
            http_response_code(400);
            $this->createResponse(false,0,array("error"=>$exception->getMessage()));
        }

    }
    function deleteStudent($id){
try{
    $sql = "delete from students where id = $id";
    $result = $this->conn->query($sql);

    if( mysqli_affected_rows($this->conn)>0){
        $this->createResponse(true,1,array("data"=>"student has been deleted"));
    }else{
        throw new Exception("There are no students with the passed id");
    }
}
catch (Exception $exception){
    $this->createResponse(false,0,array("error"=>$exception->getMessage()));
}
    }
    function updateStudent($id,$name,$email){
try{
    $query="update students set id=$id, name=$name,email=$email where id=4$id";
    $result=$this->conn->query($query);

}
catch (Exception $exception){
    $this->createResponse(false,0,array("error"=>$exception->getMessage()));
}
    }
function saveImage($file){
    $folder_name = "images/";
    $path = $folder_name.$file["name"];
    move_uploaded_file($file["tmp_name"],$path);
    $link = "http://localhost/student/$path";
    return $link;
}

function createResponse($isSuccess,$count,$data){
        echo json_encode(array(
            "success"=>$isSuccess,
            "count"=>$count,
            "data"=>$data
        ));
}
function createStudentResponse($id,$name,$email,$image_url,$created_date){
        return array(
            "id"=>$id,
            "name"=>$name,
            "email"=>$email,
            "image"=>$image_url,
        );
}
}
?>
<!-- 89784209
wedsdvsfv@gmail.com 
89784209

passed
141252363@141252363
username
asdfsdsaaassddd -->
<?php
/*include 'db_helper.php';
header("Content-Type: application/json; charset=UTF-8");
$dbHelper = new DbHelper();
$dbHelper->createDbConnection();
if($_SERVER['REQUEST_METHOD']=="POST"){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $dbHelper->insertNewStudent($name,$email);

}*/
include ("dp.php");
header("Content-Type: applecation/json;charset=UTF-8")

?>