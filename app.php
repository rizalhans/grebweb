<?php require('config.php'); ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>GrabWeb</title>
    <script>
        let webs = <?php echo json_encode($webs); ?>;
        console.log(webs);
    </script>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg  navbar-dark bg-primary">
  <a class="navbar-brand" href="index.php">GrabWEB</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
        <?php if($webs) { 
            foreach($webs as $kategori => $web) { ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $kategori; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <?php if($web) { 
                    foreach($web as $file => $item) { ?>
                        <a class="dropdown-item grepdata" href="<?php echo $file; ?>.php"><?php echo $item['nama']; ?></a>
                    <?php } 
                    } ?>
            </div>
        </li>
            <?php }
        } ?>
    </ul>
  </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h2>Action</h2>
            <p>API dapat di akses</p>
            <p id="linkapi"></p>
        </div>
        <div class="col-md-9">
            <h2>Hasil Grap</h2>
            <pre id="result-code">
                Data Hasil Grab akan muncul disini
            </pre>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <h3>Preview HTML</h3>
            <div id="hasilhtml"></div>
        </div>
        <div class="col-md-5">
            <h3>Code View</h3>
            <textarea rows="10" class="form-control" id="codeview"></textarea>
        </div>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script>
function getJsonAPI(base_url,options={},resultData) {
	var result_url = base_url;
	var request = new XMLHttpRequest()
	request.open('GET', result_url, true);
	request.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		resultData(JSON.parse(this.responseText),options);
	  }
	};
	request.send();
}
function resultAPI(response) {
    console.log(response);
    $("#result-code").html(JSON.stringify(response.dataset,null,2));
    $("#hasilhtml").html(response.preview);
    $("#codeview").val(response.raw);
    $("#linkapi").html(response.api_link);
}
    $(document).ready(function(e) {
        $(".grepdata").click(function(e){
            e.preventDefault();
            $("#result-code").html('Load data....');
            $("#hasilhtml").html('Load data....');
            $("#codeview").val('');
            $("#linkapi").html('Load data....');
            var targetLink = $(this).attr("href");
            getJsonAPI(targetLink,{},resultAPI);

        })
    })
</script>
  </body>
</html>
