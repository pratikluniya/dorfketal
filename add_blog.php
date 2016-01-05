<?php

include("header.php");
include("top_header.php");
include("side_navigation.php");

?>

<div id="wrapper">



    <div class="content animate-panel">

             <div class="row">
        <div class="col-lg-10">
            <div class="hpanel">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                        <a class="closebox"><i class="fa fa-times"></i></a>
                    </div>
                    Add Blog:
                </div>
                <div class="panel-body">
                <form method="get" class="form-horizontal">
                <div class="form-group"><label class="col-sm-2 control-label">Title:</label>

                    <div class="col-sm-10"><input type="text" name = "blog_title"  id ="blog_title" class="form-control"></div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group"><label class="col-sm-2 control-label">Content:</label>

                    <div class="col-sm-10"><textarea  id ="blog_content"  name ="blog_content" class="form-control" rows="10"></textarea></div>
                </div>

                <div class="form-group"><label class="col-sm-2 control-label">Category:</label>

                    <div class="col-sm-10"><select class="form-control m-b" name="blog_category" id ="blog_category">
                            <option value='1'>option 1</option>
                            <option  value='1'>option 2</option>
                            <option  value='1'>option 3</option>
                            <option    value='1'>option 4</option>
                        </select></div>
                </div>

                <div class="form-group"><label class="col-sm-2 control-label">Image Upload:</label>

                    <div class="col-sm-10"><input type="file" class="form-control"  id ="blog_image" name ="blog_image"></div>
                </div>
               
                 <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-2">
                        <button class="btn btn-default" type="submit">Cancel</button>
                        <input type ="button" class="btn btn-primary" value ="save" id ="btn_save">
                    </div>
                </div>
                </form>
                </div>
            </div>
        </div>
        
    </div>



    </div>

</div>

<script>
$( document ).ready(function() {

    $("#btn_save").click(function(){

        var blog_tiltle = $("#blog_title").val();
        var blog_content = $("#blog_content").val();
        var blog_category = $("#blog_category").val();
/*
        alert(blog_tiltle);
        alert(blog_content);
        alert(blog_category);*/

    var file_data = $("#blog_image").prop('files')[0];   
      var form_data = new FormData();                  
      form_data.append('userImage', file_data);
      form_data.append('blog_tiltle', blog_tiltle);
      form_data.append('blog_content', blog_content);
      form_data.append('blog_category',blog_category);  
      form_data.append('action',"upload_blog");      
      
        $.ajax({
        url: 'upload.php', 
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(data)
        {   

            //alert(data);
            if(data=="1"){
                alert("Blog has been added !!!!");
            }else{
                alert("Server error  to upload Blog !!!!");
            }

            location.reload();
            console.log(data);
        }
         
       
        
      });





    });

    });



</script>

<?php

include("footer.php");

?>

