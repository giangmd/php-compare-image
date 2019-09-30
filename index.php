<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PHP Compare Image Demo</title>
    <style>
        html {
            margin: 0;
            padding: 0;
        }
        body {
            max-width: 80%;
            margin: 0 auto;
        }
        form {
            width: 100%;
            overflow: auto;
        }
        .clearfix {
            clear: both;
        }
        .col {
            width: 50%;
            float: left;
            overflow: auto;
            /*padding: 15px;*/
        }
        .img-prev {
            padding: 15px 0;
        }
        .img-prev img {
            width: 100px;
            height: 100px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>
    <h1>PHP Compare Image Demo</h1>
    <p>Upload photo to test.</p>
    
    <?php
        if (isset($_POST['submit'])) {

            require_once('./image.compare.class.php');

            $image1 = $_FILES['image1']['tmp_name'];
            $image2 = $_FILES['image2']['tmp_name'];

            $class = new compareImages;
            $result = $class->compare($image1, $image2);

            $aExtraInfo1 = getimagesize($image1);
            $sImage1 = "data:" . $aExtraInfo1["mime"] . ";base64," . base64_encode(file_get_contents($image1));

            $aExtraInfo2 = getimagesize($image2);
            $sImage2 = "data:" . $aExtraInfo2["mime"] . ";base64," . base64_encode(file_get_contents($image2));

            ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="col">
                        <input type="file" name="image1" id="image1" required="required">
                        <div id="s-image1" class="img-prev">
                            <img src="<?php echo $sImage1 ?>" >
                        </div>
                    </div>
                    <div class="col">
                        <input type="file" name="image2" id="image2" required="required">
                        <div id="s-image2" class="img-prev">
                            <img src="<?php echo $sImage2 ?>" >
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <input type="submit" name="submit" value="SUBMIT">
                </form>
            <?php

            if ($result <= 10) {
                echo "<h4>There are photos similar.</h4>";
            } else {
                echo "<h4>There are photos different.</h4>";
            }

        } else {
            ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="col">
                        <input type="file" name="image1" id="image1" required="required">
                        <div id="s-image1" class="img-prev"></div>
                    </div>
                    <div class="col">
                        <input type="file" name="image2" id="image2" required="required">
                        <div id="s-image2" class="img-prev"></div>
                    </div>
                    <div class="clearfix"></div>
                    <input type="submit" name="submit" value="SUBMIT">
                </form>
            <?php
        }
    ?>

    <script>
        function readURL(input, index) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                var _img = '<img src="' + e.target.result + '" >'
              $('#s-image'+index).html(_img)
            }
            
            reader.readAsDataURL(input.files[0]);
          }
        }

        $("#image1").change(function() {
          readURL(this, 1);
          $('#s-image1').html('')
        });
        $("#image2").change(function() {
          readURL(this, 2);
          $('#s-image2').html('')
        });
    </script>
</body>
</html>