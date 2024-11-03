<?php
// if($_SESSION['role'] == 0 && $_SESSION['admin'] ){
  
    if(isset($_POST['sendMessage'])){
    $ccId = $_SESSION['id'];
      $message = $_POST['message'];
      if(empty($message)){
        $errorMessage[]="The Message field is empty!";
      }elseif(strlen($message)>500){
        $errorMessage[]="(500) max for this field!";
      }
      if(empty($errorMessage)){
        $insert = "INSERT INTO `blog` VALUES (NULL ,'$message',current_timestamp(),$ccId)";
        $i = mysqli_query($connectSQL ,$insert);
      }
    }
?>

<!-- contact us -->
    <section id="contact-us"  class="contact-us" style="background-color: black;">
        <div class="container">
            <h2 class="text-center pt-4 text-light">contact us</h2>
        <div class="container-fliud">
            <div class="row m-0">
                <div class="col-md-6 p-0">
                    <div class="box-frame">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3822.899513729006!2d109.00582548195976!3d-7.258481321686115!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f8584ae5245ed%3A0x4027a76e352f9d0!2sKec.%20Bumiayu%2C%20Kabupaten%20Brebes%2C%20Jawa%20Tengah!5e0!3m2!1sid!2sid!4v1730433338046!5m2!1sid!2sid" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-md-6 p-0">
                    <div class="contact-form wow pulse">
                        <form id="contact" action="" method="post">
                          <div class="row">
                            <div class="col-lg-12">
                              <fieldset>
                                <textarea name="message" rows="6" id="message" placeholder="Message"></textarea>
                              </fieldset>
                              <?php if(!empty($errorMessage)):  ?>
                                  <div class="alert alert-danger" role="alert">
                              <?php echo $errorMessage[0] ;?>
                            </div>
                            <?php endif; ?>
                            </div>
                            <div class="col-lg-12">
                              <fieldset>
                                <button name="sendMessage" id="form-submit" class="btn btn-outline-info">Send Message</button>
                              </fieldset>
                            </div>
                          </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>