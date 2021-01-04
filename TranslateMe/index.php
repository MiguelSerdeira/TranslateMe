<?php

   $conn = new mysqli('localhost','root','','translateme');



   if (isset($_POST['register'])) {
      $name = $conn->real_escape_string($_POST['name']);
      $email = $conn->real_escape_string($_POST['email']);
      $password = $conn->real_escape_string($_POST['password']);

      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $sql = $conn->query("SELECT id FROM users WHERE email='$email'");
          if ($sql->num_rows > 0)
              exit('failedUserExists');
          else {
              $ePassword = password_hash($password, PASSWORD_BCRYPT);
              $conn->query("INSERT INTO users (name,email,password,createdOn) VALUES ('$name', '$email', '$ePassword', NOW())");
            exit('success');

         }

        }else
        exit('failedEmail');

    }


?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>TranslateMe</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
      <style type="text/css">
         .user{
         font-weight: bold;
         color:black;
         }
         .time{
         color: gray;
         }
         .userComment {
         color: #000;
         }
         .replies .comment{
         margin-top:20px;
         margin-bottom:20px;
         }
         .replies {
         margin-left:20px;
         }
         #registerModal, input, #logInModal input{
         margin-top:10px;
         }
      </style>
   </head>
   <body>
      <div class="modal" id="registerModal">
         <div class="modal-dialog">
         <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registration Form</h5>
                </div>
                <div class="modal-body">
                    <input type="text" id="userName" class="form-control" placeholder="Your Name">
                    <input type="email" id="userEmail" class="form-control" placeholder="Your Email">
                    <input type="password" id="userPassword" class="form-control" placeholder="Password">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="registerBtn">Register</button>
                    <button class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
         </div>
      </div>
      <div class="container" style = "margin-top:20px;">
         <div class="row">
            <div class="col-md-12" align="right">
               <button class = "btn btn-primary" data-toggle="modal" data-target="#registerModal">Register</button>
               <button class = "btn btn-success">Log in</button>
            </div>
         </div>
         <div class="row" style= "margin-top: 20px; margin-bottom: 20px;">
            <div class="col-md-12">
               <textarea class="form-control" placeholder="Add public comment" cols="30" rows="2"></textarea><br>
               <button style="float:right;" class="btn-primary btn">Add Comment</button>
            </div>
         </div>
         <div class="row" style= "margin-top: 20px;">
            <div class="col-md-12">
               <h2><b> 335 Comments</b> </h2>
               <div class="userComments">
                  <div class="comment">
                     <div class="user">Miguel<span class="time"> 4/01/2021</span></div>
                     <div class="userComment">Comentário</div>
                     <div class="replies">
                        <div class="comment">
                           <div class="user">Miguel<span class="time"> 4/01/2021</span></div>
                           <div class="userComment">Comentário</div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="http://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      <script type="text/javascript">
         $(document).ready(function (){
             $("#registerBtn").on('click', function(){
                 var name = $("#userName").val();
                 var email = $("#userEmail").val();
                 var password = $("#userPassword").val();
                 if (name != "" && email != "" && password != "") {
                    $.ajax({
                        url: 'index.php',
                        method: 'POST',
                        dataType: 'text',
                        data: {
                            register: 1,
                            name: name,
                            email: email,
                            password: password
                        }, success: function (response){
                            console.log(response);
                        }
                    })
                 } else
                 alert('Please check your inputs');
             });
         });
      </script>
   </body>
</html>