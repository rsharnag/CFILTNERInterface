<html>
<head>
<script>
    window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
</script>
<link rel="shortcut icon" href="src/css/favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="src/js/jquery.js"></script>
<script type="text/javascript" src="src/js/bootbox.js"></script>
<script type="text/javascript" src="src/js/bootstrap.js"></script>
<script>
    var timer ;

    $(document).ready(function(){
        $(".progress").hide();
        $('body').on('click','#submit',function(){
            var form = new FormData($('#form')[0]);
            $.ajax({
                url:'upload_file.php',
                type:'POST',
                beforeSend:loadTimer,
                complete:stopTimer,
                async:true,
                success:function(res){
                    bootbox.alert("Your files have been imported successfully.",function() {window.close();});
                },
                data:form,
                cache:false,
                contentType:false,
                processData:false
            });
        });
    });
    function loadTimer(){
        $(".progress").show();
        timer= setInterval(function(){progressTimer()},500);
    }
    function progressTimer(){
        var session;
        $.ajaxSetup({cache: false});
        $.ajax({
            url:'sessionRequest.php',
            type:'POST',
            cache:false,
            async:false,
            success:function(data){
                session=JSON.parse(data);
            }
        });
        //document.getElementsById("progressB ar").setAttribute("aria-valuenow",session["progress"]+"");
        //document.getElementsByClassName("sr-only").innerHTML=session['progress']+"% complete";
        $("#progressBar").attr({"aria-valuenow" : session['progress']+''});
        $("#progressBar").css({"width":session['progress']+"%"});
        $(".sr-only").html(session['progress']+"% complete");
    }
    function stopTimer(){
        clearInterval(timer);
    }

</script>
<link rel="stylesheet" href="src/css/bootstrap.css">	
</head>
<body>
    <div id="uploadsource" style="float:left">
	    <form name="form" id="form" >
            <label for="file"><b>Upload Source Corpora</b></label>
		    <input type="file" name="file1" id="file1"><br>
		    <input class="btn btn-lg btn-success" type="button" id="submit" name="submit" value="Upload File">
	    </form>
        <div class="progress progress-striped active" style="border: 2px solid dodgerblue">
            <div id="progressBar" class="progress-bar"  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                <span class="sr-only">0% Complete</span>
            </div>
        </div>
<!---->
<!--        --><?php
//            if (!empty($_GET['success']) || $_GET['success']==1) {
//			echo "<script>
//bootbox.alert(\"Your files have been imported successfully.\",function() {window.close();});
//				  </script>"; //generic success notice
//		 }
//		?>
	</div>
</body>
<html>
