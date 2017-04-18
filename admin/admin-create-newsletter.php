<?php
/**
 * Created by PhpStorm.
 * User: Lenoir
 * Date: 4/4/2017
 * Time: 1:21 PM
 * https://www.ephox.com/my-account/api-key-manager/
 */
require_once "header.php";
require_once "model/database.php";
require_once "model/admin.php";
$db = Database::getDB();
$emailTitle = "";
$emailBody = "";
$email = "";
$currentAdmin = AdminUser::getUserDetailsById($db, $_SESSION['user_id']);
$parks = AdminUser::getAllParks($db);
if (isset($_POST['submit'])) {
    //var_dump($_POST);
    if ($_POST['listPark'] != ""){
        $users = AdminUser::getUsersByWishlistAboutParks($db, $_POST['listPark']);
    }
    else {
        $users = AdminUser::findGeneralSubscribers($db);
    }

    //var_dump($users);
    require_once '../vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'canadanationalpark@gmail.com';
    $mail->Password = 'canada123';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('canadanationalpark@gmail.com', 'do-not-reply');
    foreach ($users as $user) {
        $mail->AddBCC($user->user_email, $user->user_name);
    }
    $mail->addAddress("canadanationalpark@gmail.com");
    $mail->isHTML(true);
    $mail->Subject = $_POST['title'];
    $mail->Body = "Dear beloved user,<br/>" .
        'Thank you so much for your support to out website.<br/>' .
        $_POST['body'] .
        '<br/> Thank you for your time! We hope to see you again at our website.' .
        '<br/> Admin from Marvel team!' .
        '<br/>' . $currentAdmin->first_name . " " . $currentAdmin->last_name
    ;
    if(!$mail->send()) {
        echo "<div class=\"alert alert-danger\"> Mailer Error: $mail->ErrorInfo</div>";
    }
    else {
        echo "<div class=\"alert alert-success\"> The email has been sent to user(s).</div>";
        echo "<a class='btn btn-default' href='index.php'>Back to Login page</a>";
    }
}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=p1304d9rxdc66xav9ollfiv6xe7a6jkls6h5luvl68sfl8cn"></script>

<script>tinymce.init({
        selector: "textarea",
        convert_urls : false,
        theme: "modern",
        paste_data_images: true,
        height : "300",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        toolbar2: "print preview media | forecolor backcolor emoticons",
        image_advtab: true,
        file_picker_callback: function(callback, value, meta) {
            if (meta.filetype == 'image') {
                $('#upload').trigger('click');
                $('#upload').on('change', function() {
                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        callback(e.target.result, {
                            alt: ''
                        });
                    };
                    reader.readAsDataURL(file);
                });
            }
        },
        templates: [{
            title: 'Test template 1',
            content: 'Test 1'
        }, {
            title: 'Test template 2',
            content: 'Test 2'
        }]
    });</script>
<h1>Create News Letter</h1>

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="glyphicon">&#xe101;</span> <b>Note:</b></div>
        <div class="panel-body">
            <p>
                This place is for admin to send news letter to all subscribers of the website. Be careful with 2 options below and read instruction before sending email.
            </p>
            <p>
                The sending email address will be: <b><mark>canadanationalpark@gmail.com</mark></b>
            </p>
            <div>
                <p>
                    <span class="glyphicon">&#x2709;</span> <b>General:</b> this option will help you to send email to all subscribers in the website. Make sure your mail has general information about all parks or the website.
                </p>
                <p>
                    <span class="glyphicon">&#x2709;</span> <b>Specific Park(s):</b> this option will let you to choose 1 or more parks and every subscriber has the park(s) on their wishlist will recieve your mail. Make sure your mail's information is related to those specific parks.
                </p>
            </div>
        </div>
    </div>
<form class="form-horizontal" method="post" action="admin-create-newsletter.php">
    <fieldset>
        <legend>Please fill in the form below:</legend>

        <div class="form-group">
            <label class="control-label col-sm-2" for="title">Email Title:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="title" placeholder="Enter Email title" name="title" value="<?php echo $emailTitle ?>" />
                <br/><span id="titleErr"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="body">Email Body:</label>
            <div class="col-sm-10">
                <textarea id="body" name="body" value="<?php echo $emailBody ?>" /></textarea>
                <br/><span id="bodyErr"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="topic">Topic of the email:</label>
            <div class="col-sm-10">
                <label class="radio-inline"><input type="radio" name="topic" value="general" checked>General</label>
                <label class="radio-inline"><input type="radio" name="topic" value="specific" >Specific Park(s)</label>
                <div id="park-multi-select">
                    <select  class="selectpicker" multiple data-selected-text-format="count > 2"
                             data-actions-box="true" data-header="Select parks:" data-width="300px" data-live-search="true">
                        <?php
                            foreach ($parks as $park){
                                echo "<option value='$park->id'>$park->name</option>";
                            }
                        ?>
                    </select>
                </div>
                <br/><span id="selectPickerErr"></span>
                <input type="hidden" id="listPark" name="listPark" value=""/>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button id="myBtn" type="submit" class="btn btn-success" name="submit">Send to Users</button>
                <a class="btn btn-default" href="admin-list.php">Cancel</a>
            </div>
        </div>
    </fieldset>
</form>
</div>
<script>
    $(document).ready(function(){
        $('.selectpicker').prop('disabled', true);
        $('.selectpicker').selectpicker('refresh');
        $('input[type=radio][name=topic]').change(function() {
            if (this.value == 'specific') {
                $('.selectpicker').prop('disabled', false);
                $('.selectpicker').selectpicker('refresh');
            }
            else if (this.value == 'general') {
                $('.selectpicker').prop('disabled', true);
                $('.selectpicker').selectpicker('refresh');
            }
        });

        $(".bootstrap-select").click(function(){
            $('.dropdown-menu.open').css({'z-index':10000, 'max-height':'500px' });
        });

        $("#myBtn").click(function(){
            if ($('#title').val() === ""){
                $("#titleErr").html("Please enter Email title");
                return false;
            }
            if (tinyMCE.activeEditor.getContent()  === ""){
                $("#bodyErr").html("Please enter Email body");
                return false;
            }
            if ($('input[type=radio][name=topic]:checked').val() === "specific") {
                if ($('.selectpicker').selectpicker('val').toString() !== "") {
                    var parks = $('.selectpicker').selectpicker('val').toString();
                    $('#listPark').val(parks);
                } else{
                    $("#selectPickerErr").html("Please select one or more parks above");
                    return false;
                }
            }
        });

        setInterval(function(){
            var option = $('input[type=radio][name=topic]:checked').val(); // general or specific
            var parks = $('.selectpicker').selectpicker('val').toString();
            $.post("admin-get-number-of-users.php", { option : option, parks : parks}, function(data){
                $("#selectPickerErr").html("Currently found " + data + " user(s) to send email to!").css('color','green');
            });
        }, 2000);
    });
</script>