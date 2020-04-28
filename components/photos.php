    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/style.css" rel="stylesheet">
    <style type="text/css">
#w{
  width: 30%;
}
    </style>

    <section style="border:1px solid #DCDCDC; z-index: 101;">
          <div class="panel-heading">
            
            <h3 class="panel-title">Photos</h3>
          </div>
      
          <div class="panel-body">
            <ul class="photos gallery-parent">
              <li id="w"><a href="../img/sample1.jpg" data-hover="tooltip" data-placement="top" title="image" data-gallery="mygallery" data-parent=".gallery-parent" data-title="title" data-footer="this is a footer" data-toggle="lightbox"><img src="../img/sample1.jpg" class="img-thumbnail" alt=""></a></li>
              <li id="w"><a href="../img/sample2.jpg" data-hover="tooltip" data-placement="top" title="image" data-gallery="mygallery" data-parent=".gallery-parent" data-title="title" data-footer="this is a footer" data-toggle="lightbox"><img src="../img/sample2.jpg" class="img-thumbnail" alt=""></a></li>
              <li id="w"><a href="../img/sample3.jpg" data-hover="tooltip" data-placement="top" title="image" data-gallery="mygallery" data-parent=".gallery-parent" data-title="title" data-footer="this is a footer" data-toggle="lightbox"><img src="../img/sample3.jpg" class="img-thumbnail" alt=""></a></li>
              <li id="w"><a href="../img/sample4.jpg" data-hover="tooltip" data-placement="top" title="image" data-gallery="mygallery" data-parent=".gallery-parent" data-title="title" data-footer="this is a footer" data-toggle="lightbox"><img src="../img/sample4.jpg" class="img-thumbnail" alt=""></a></li>
              <li id="w"><a href="../img/sample5.jpg" data-hover="tooltip" data-placement="top" title="image" data-gallery="mygallery" data-parent=".gallery-parent" data-title="title" data-footer="this is a footer" data-toggle="lightbox"><img src="../img/sample5.jpg" class="img-thumbnail" alt=""></a></li>
              <li id="w"><a href="../img/sample6.jpg" data-hover="tooltip" data-placement="top" title="image" data-gallery="mygallery" data-parent=".gallery-parent" data-title="title" data-footer="this is a footer" data-toggle="lightbox"><img src="../img/sample6.jpg" class="img-thumbnail" alt=""></a></li>
            </ul>
          </div>
    </section>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/ekko-lightbox.js"></script>
    <script>
      $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox();
      }); 
      $(function () {
      $('[data-hover="tooltip"]').tooltip()
      })
    </script>