<?PHP include "DB.PHP"; ?>
<?PHP include "MYSQL.PHP"; ?>


<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>TranslateMe</title>
      <link rel="stylesheet" href="style.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
     
   </head>
   <body style=" background:linear-gradient(to right, #7592A2, #516395);";>

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

      <div class="modal" id="logInModal">
         <div class="modal-dialog">
         <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Log In Form</h5>
                </div>
                <div class="modal-body">
                    <input type="email" id="userLEmail" class="form-control" placeholder="Your Email">
                    <input type="password" id="userLPassword" class="form-control" placeholder="Password">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="loginBtn">Login</button>
                    <button class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
         </div>
      </div>

      
      
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom px-4">
        <a class="navbar-brand text-white" href="#">TranslateMe</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

            <?php
            
            if (!$loggedIn) echo '
           
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
              
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <button class="btn btn-success" data-toggle="modal" data-target="#logInModal">Log In</button>
                    </li>
                    <li class="nav-item px-2">
                        <button class="btn btn-secondary" data-toggle="modal" data-target="#registerModal">Register</button>
                    </li>
              
                    </ul>
                    </div>
                            
                    ';
            else echo '
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                    <li class="nav-item px-2">
                     <a href="logout.php" class="btn btn-secondary">Log Out</a>
                    </li>
                 </ul>
            </div>
                    ';
            ?>


        </nav>
        

      
</div>

<div class="container justify-content-center">
    <div class="d-flex mt-4 justify-content-center">
    <?php
               if ($loggedIn == true){
               echo'<textarea class="form-control" id ="mainComment" placeholder="Add a public comment" cols="30" rows="2"></textarea><br>';
           
                echo'<button style="float:right;" class="btn-primary btn" onClick="isReply = false" id="addComment">Add Comment</button>';
               }else{
                echo'<textarea disabled class="form-control" id ="mainComment" placeholder="You need to be logged in to make a post!" cols="30" rows="2"></textarea><br>';
               }  
               
               ?>
  </div>
</div>

            


   <div class="px-4">
         <div class="row" style= "margin-top: 20px;">
            <div class="col-md-12">
           
               <h2><b id="numComments"> <?php echo $numComments ?> Comments</b> </h2>
               <div class="userComments">
                
               </div>
  
            </div>
         </div>
      </div>
      <div class="row replyRow pt-4" style= "display:none;">
            <div class="col-md-12 d-flex">
            <?php
               if ($loggedIn == true){
                echo '<textarea class="form-control" id ="replyComment" placeholder="Add a public comment" cols="30" rows="2"></textarea><br>';
                echo'<button style="float:right;" class="btn-primary btn" onClick="isReply = true" id="addComment">Add Reply</button>';
                } else echo '<textarea disabled class="form-control" id ="replyComment" placeholder="You need to be logged in to reply to a comment!" cols="30" rows="2"></textarea><br>';

              ?>
               <button style="float:right;" class="btn btn-secondary" onClick="$('.replyRow').hide();">Close</button>
            </div>
         </div>

</div>
      <script src="http://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      <script type="text/javascript">
        
    
     var isReply = false, commentID = 0, max = <?php echo $numComments ?>;

        $(document).ready(function (){
         $("#addComment, #addReply").on('click', function () {

               var comment;
               if(!isReply)
                comment = $("#mainComment").val();
               else comment = $("#replyComment").val();

               if (comment.length > 5) {
                    $.ajax({
                        url: 'index.php',
                        method: 'POST',
                        dataType: 'text',
                        data: {
                            addComment: 1,
                            comment: comment,
                            isReply, isReply,
                            commentID: commentID
                        }, success: function (response) {
                           max ++;
                           $("#numComments").text(max + " Comments");
                        if(!isReply){
                           $(".userComments").prepend(response);
                           $("#mainComment").val("");
                        }
                         else{
                            commentID = 0;
                           $("replyComment").val("");
                           $(".replyRow").hide();
                           $('.replyRow').parent().next().append(response);
                         }
                        }
                    });
               } else
                   alert('Please Check Your Inputs');
           });

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
                           if (response == "failedEmail"){
                              alert('Please insert valid email adress!');
                           }else if (response == "failedUserExists"){
                              alert('User with this email already exists');

                           }else window.location = window.location;
                        }
                    })
                 } else
                 alert('Please check your inputs');
             });
          

          
             $("#loginBtn").on('click', function () {
               var email = $("#userLEmail").val();
               var password = $("#userLPassword").val();

               if (email != "" && password != "") {
                    $.ajax({
                        url: 'index.php',
                        method: 'POST',
                        dataType: 'text',
                        data: {
                            logIn: 1,
                            email: email,
                            password: password
                        }, success: function (response) {
                            if (response === 'failed')
                                alert('Please check your login details!');
                            else
                                window.location = window.location;
                        }
                    });
               } else
                   alert('Please Check Your Inputs');
           });
           getAllComments(0, <?php echo $numComments ?>);
        });

        function reply(caller){
           commentID = $(caller).attr('data-commentID');
           $(".replyRow").insertAfter($(caller));
           $('.replyRow').show();
        }

        function getAllComments(start,max){
         if (start > max){
            return;
         }
         $.ajax({
                        url: 'index.php',
                        method: 'POST',
                        dataType: 'text',
                        data: {
                            getAllComments: 1,
                            start:start
                        }, success: function (response) {
                           $(".userComments").append(response);
                           getAllComments((start+20),max);
                        }
                    });
        }  
      </script>
   </body>
</html>