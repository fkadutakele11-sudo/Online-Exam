<?php
session_start();
include "db.php";

$error = "";

/* =============================
   LOGIN ATTEMPT LIMIT
============================= */
if(!isset($_SESSION['attempt'])){
    $_SESSION['attempt'] = 0;
}

/* =============================
   LOGIN LOGIC (DB LOGIC SAME)
============================= */
if($_SERVER["REQUEST_METHOD"]=="POST"){

    $name = trim($_POST['name'] ?? '');
    $student_id = trim($_POST['student_id'] ?? '');
    $password = trim($_POST['password'] ?? '');

    /* EMPTY VALIDATION */
    if($name=="" && $student_id==""){
        $error="Username or Student ID must not be empty.";
    }
    elseif($password==""){
        $error="Password must not be empty.";
    }
    elseif($_SESSION['attempt'] >= 5){
        $error="Too many login attempts. Try again later.";
    }
    else{

        /* ======================
           STUDENT LOGIN
           (QUERY NOT CHANGED)
        ====================== */
        if($student_id!=""){

            $checkID=$conn->query(
                "SELECT * FROM users WHERE student_id='$student_id'"
            );

            if($checkID->num_rows==0){
                $_SESSION['attempt']++;
                $error="Invalid your ID.";
            }
            else{

                $sql="SELECT * FROM users 
                      WHERE student_id='$student_id' 
                      AND password='$password'";
                $result=$conn->query($sql);

                if($result->num_rows>0){

                    $row=$result->fetch_assoc();
                    $_SESSION['student_id']=$row['student_id'];
                    $_SESSION['attempt']=0;

                    header("Location: student.php");
                    exit();
                }else{
                    $_SESSION['attempt']++;
                    $error="Invalid password.";
                }
            }
        }

        /* ======================
           ADMIN / INSTRUCTOR LOGIN
           (QUERY NOT CHANGED)
        ====================== */
        if($name!=""){

            $checkUser=$conn->query(
                "SELECT * FROM users WHERE name='$name'"
            );

            if($checkUser->num_rows==0){
                $_SESSION['attempt']++;
                $error="Invalid username.";
            }
            else{

                $sql="SELECT * FROM users 
                      WHERE name='$name' 
                      AND password='$password'";
                $result=$conn->query($sql);

                if($result->num_rows>0){

                    $row=$result->fetch_assoc();
                    $_SESSION['attempt']=0;

                    if($row['role']=="admin"){
                        header("Location: admin.php");
                        exit();
                    }

                    if($row['role']=="instructor"){
                        header("Location: instructor.php");
                        exit();
                    }

                }else{
                    $_SESSION['attempt']++;
                    $error="Invalid password.";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Online Exam System</title>

<style>

body{
    margin:0;
    font-family:Arial, Helvetica, sans-serif;
    background:linear-gradient(120deg,#2980b9,#6dd5fa);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* LOGIN CARD */
.login-box{
    background:white;
    padding:40px;
    width:350px;
    border-radius:10px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

.login-box h2{
    text-align:center;
    margin-bottom:25px;
}

/* INPUTS */
input{
    width:100%;
    padding:10px;
    margin:8px 0 18px 0;
    border:1px solid #ccc;
    border-radius:5px;
}

button{
    width:100%;
    padding:12px;
    background:#2980b9;
    border:none;
    color:white;
    font-size:16px;
    border-radius:5px;
    cursor:pointer;
}

button:hover{
    background:#1f6690;
}

.note{
    font-size:12px;
    text-align:center;
    color:#666;
    margin-top:15px;
}

/* =====================
   PROFESSIONAL MODAL
===================== */
.modal{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    display:flex;
    justify-content:center;
    align-items:center;
}

.modal-content{
    background:white;
    padding:25px;
    border-radius:10px;
    width:320px;
    text-align:center;
    animation:fadeIn .3s ease;
}

.modal-content h3{
    color:#e74c3c;
}

.modal-content button{
    margin-top:15px;
    width:100px;
}

@keyframes fadeIn{
    from{transform:scale(.8);opacity:0;}
    to{transform:scale(1);opacity:1;}
}

</style>
</head>

<body>

<div class="login-box">

<h2>Online Exam Login</h2>

<form method="POST">

<label>Name</label>
<input type="text" name="name">

<label>Student ID (students only)</label>
<input type="text" name="student_id">

<label>Password</label>
<input type="password" name="password">

<button type="submit">Login</button>

</form>

<p class="note">
Admin / Instructor use Name + Password<br>
Students use Student ID + Password
</p>

</div>

<?php if($error!=""){ ?>
<div id="errorModal" class="modal">
    <div class="modal-content">
        <h3>Login Error</h3>
        <p><?php echo $error; ?></p>
        <button onclick="closeModal()">OK</button>
    </div>
</div>
<?php } ?>

<script>
function closeModal(){
    document.getElementById("errorModal").style.display="none";
}
</script>

</body>
</html>