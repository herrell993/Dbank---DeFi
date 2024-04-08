<?php
require_once 'vendor/autoload.php';
$text='';
if(isset($_POST['submit'])){
    $yourApiKey = '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';
    $client = OpenAI::client($yourApiKey);
    //print_r($_FILES);
    $file = $_FILES['file']['tmp_name'];

    $response = $client->audio()->transcribe([
        'model' => 'whisper-1',
        'file' => fopen($file, 'r'),
        'response_format' => 'verbose_json',
    ]);

    //print_r($response);
    foreach($response->segments as $segment){
        $text.=$segment->text;

    }
    

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta chatset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Speech to text</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="">Select MP3 File</label>
                                <input type="file" name="file" class="form-control"></input>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" name="submit" >Submit</button>
                                <button class="btn btn-primary" onclick="saveToTextFile()">Save to Text File</button>
                            </div>
                            <div class="form-group">
                                <?php
                                    echo '<p id = "content">'. $text. '</p>';
                                ?>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function saveToTextFile() {
      var content = document.getElementById("content").innerText;
      var blob = new Blob([content], { type: "text/plain" });

      var a = document.createElement("a");
      a.href = URL.createObjectURL(blob);
      a.download = "content.txt";
      a.style.display = "none";
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
    }
  </script>
</body>
</html>