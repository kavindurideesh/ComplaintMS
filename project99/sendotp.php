<?php  
ob_start();



// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Require the autoloader for PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function generateNumericOTP($n) {
	


	$generator = "1357902468";


	$result = "";

	for ($i = 1; $i <= $n; $i++) {
		$result .= substr($generator, (rand()%(strlen($generator))), 1);
	}

	
	return $result;
}

session_start();
include ("connection.php");

if(isset($_SESSION['user_id']) && isset($_SESSION['email'])){
    
    $user=$_SESSION['user_id'];
    $email=$_SESSION['email'];
    $otp=generateNumericOTP(6);
    date_default_timezone_set('Asia/Colombo'); 
    $date = date("Y-m-d H:i:s", strtotime("+0 minutes"));
    $_SESSION['timestamp']=$date;

    $insertQuery = "INSERT INTO authentication(user_id,timestamp,otp) VALUES ('$user','$date','$otp')";
    $result=mysqli_query($con,$insertQuery);
	$id=1;
    $sql="select * from stmp where id='$id'";
	$val=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($val);

    $mail = new PHPMailer(true);


try {
    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $row['email'];                     // SMTP username
    $mail->Password   = 'ugnlcwivmkrommgt';                               // SMTP password
    $mail->SMTPSecure = 'ssl';         
    $mail->Port       = 465;                                    // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    // Recipients
    $mail->setFrom($row['email'], 'OTP');
    $mail->addAddress($email, 'OTP');     // Add a recipient
    
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Verification';
    $mail->Body    = $otp;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';

 
    header("location:otp.php");
     ob_end_flush();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    session_unset();
    $_SESSION['error']=$mail->ErrorInfo;
    
   header("location:login.php");
   ob_end_flush();

}
   

}





?>
<script>
if(window.history.replaceState){
    window.history.replaceState(null,null,window.location.href);
}</script>
