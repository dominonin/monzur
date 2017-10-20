<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Administration</title>

  <!-- Bootstrap core CSS -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/dropzone.css" rel="stylesheet">

  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/dashboard.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
  <?php
    if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.html');
    }
?>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false"
            aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="../index.html">Monzur</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a id="settings" href="#settings">Settings</a></li>
            <li><a data-toggle="modal" data-target="#helpModal" href="#help">Help</a></li>
            <li><a href="#logout">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#overview">Overview</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#accolades">Accolades</a></li>
            <li><a href="#faq">FAQ</a></li>
            <li><a href="#photos">Photos</a></li>
            <li><a href="#videos">Videos</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>

          <div id="stats" class="text-center">
            <div class="row">
              <div class="col-lg-4" id="photo-info">
                <h2>Photos</h2>
                <img src="dash_content/photos-icon.png" height="128px" width="128px">
                <div id="photo-count"></div>
              </div>

              <div class="col-lg-4" id="accolade-info">
                <h2>Accolades</h2>
                <img src="dash_content/accolades-icon.png" height="128px" width="128px">
                <div id="accolades-count"></div>
              </div>
              <div class="col-lg-4" id="video-info">
                <h2>Videos</h2>
                <img src="dash_content/videos-icon.png" height="128px" width="128px">
                <div id="videos-count"></div>
              </div>
              <div class="col-lg-4 col-lg-offset-4" id="third-party-links">
                <h2><a href="https://login.mailchimp.com" target="__blank">Mail Chimp - Newsletter Creation</a></h2>
                <h2><a href="https://sagenda.net/Accounts/Login" target="__blank">Sagenda - Event Scheduling</a></h2>
              </div>
            </div>
          </div>

          <div id="editor">
            <div class="row">
              <div class="col-lg-10">
                <h2 class="sub-header"></h2>
              </div>
              <div class="col-lg-2">
                <button id="add" type="button" class="btn btn-default" aria-label="Add Media">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
              </button>
                <button id="minus" type="button" class="btn btn-default" aria-label="Remove Media">
                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
              </button>
                <button id="reorder" type="button" class="btn btn-default" aria-label="Re-order Media" state="re-order">Re-order</button>
              </div>
            </div>
            <div id="status"></div>
            <div id="about-img"></div>
            <form class="form-inline">
              <div id="accolade_upload">
                <label for="sel1">Media Type:</label>
                <select class="form-control" id="accolade_select">
                <option selected>Photo</option>
                <option>Video</option>
              </select>
              </div>
              <div class="form-group col-lg-6" id="video_upload">
                <label for="Name">YouTube URL:</label>
                <input class="form-control" id="videourl" placeholder="Link to video">
                <button id="addVideo">Add Video</button>
              </div>
            </form>
            <form class="dropzone center-block" id="upload_form">
              <input type="hidden" name="content" value="about" id="content_type">
            </form>
            <div id="about-body"></div>
            <table class="table table-striped" id="myTable">
              <thead>
                <tr>
                  <th id="content"></th>
                  <th>Title</th>
                  <th>Caption</th>
                  <th id="year">Year</th>
                  <th>Operations</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
            <button type="button" class="btn btn-primary" id="about-edit-btn">Edit Text</button>
            <button type="button" class="btn btn-primary" id="about-edit-cancel">Cancel</button>
            <button type="button" class="btn btn-primary" id="about-edit-confirm">Confirm</button>
          </div>

        </div>
      </div>

      <!-- Modal -->
      <div id="delete-modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Confirm Deletion</h4>
            </div>
            <div class="modal-body">
              <img class="img-responsive">
              <p>Are you sure you want to delete this item and all associated data?</p>
            </div>
            <div class="modal-footer">
              <button id="delete-confirm" type="button" class="btn btn-default" data-dismiss="modal">Confirm</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>

      <div id="delete-modal-video" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Confirm Deletion</h4>
            </div>
            <div class="modal-body">
              <video poster="" height="100px" width="100px">
                <source>
              </video>
              <p>Are you sure you want to delete this video and all associated data?</p>
            </div>
            <div class="modal-footer">
              <button id="delete-confirm" type="button" class="btn btn-default" data-dismiss="modal">Confirm</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>

      <div id="settings-modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Homepage Settings</h4>
            </div>
            <div class="modal-body">
              <h4>Homepage Text</h4>
              <div class=" form-group row">
                <div class="col-xs-3">
                  <label for="top-heading">Top Heading</label>
                  <input class="form-control" id="top-heading">
                  <div class="input-group">
                    <label class="btn btn-default">Change<input id="top_submit" type="submit" style="display: none;" data-pos="top"></label>
                  </div>
                  <br>
                  <label for="bottom-heading">Bottom Heading</label>
                  <input class="form-control" id="bottom-heading">
                  <div class="input-group">
                    <label class="btn btn-default">Change<input id="bottom_submit" type="submit" style="display: none;" data-pos="bottom"></label>
                  </div>
                  <br>
                  <label for="lower-right-heading">Lower Right Heading</label>
                  <input class="form-control" id="lower-right-heading">
                  <div class="input-group">
                    <label class="btn btn-default">Change<input id="lr_submit" type="submit" style="display: none;" data-pos="lower-right"></label>
                  </div>
                </div>
              </div>
              <br>
              <h4>Mobile Background Image</h4>
              <img>
              <br>
              <div class="input-group">
                <label class="btn btn-default btn-file">Browse<input id="mobile_bg" type="file" style="display: none;"></label>
                <label class="btn btn-default">Upload<input id="bg_submit" name="bg" type="submit" style="display: none;"></label>

              </div>
              <br>

              <h4>Homepage Sound (MP3 Only)</h4>
              <audio controls>
                <source type="audio/mpeg">
              </audio>
              <div class="input-group">
                <label class="btn btn-default btn-file">Browse<input id="audio" type="file" style="display: none;"></label>
                <label class="btn btn-default">Upload<input id="audio_submit" name="song" type="submit" style="display: none;"></label>

              </div>

              <br>


              <h4>Home Page Video Background (Desktop only)</h2>
                <video autoplay>
                  <source>
                </video>
                <div class="input-group">
                  <label class="btn btn-default btn-file">Browse<input id="video_bg" type="file" style="display: none;"></label>
                  <label class="btn btn-default">Upload<input id="vbg_submit" type="submit" style="display: none;"></label>

                </div>
            </div>
            <div class="modal-footer">
              <button id="settings-close" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>

      <!-- Help Modal -->
      <div id="helpModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">User Guide</h4>
            </div>
            <div class="modal-body">
              <h2 class="text-center">Overview</h2>
              <p>Default landing page. Gives simple total of the three types of media on the site - Photos, Accolades, and Videos.</p>
              <h2 class="text-center">Settings</h2>
              <p>Allows you to change site mobile background for small devices, site video for computers, and site song for
                all devices. Songs can <b>only be MP3s - an error will occur if it isn't an MP3.</b> Keep in mind a page
                refresh might be required for changes to take effect. On success of any changes, an alert will show saying
                it is uploaded successfully. To change any of the 3 things listed above, click the browse button below the
                item you wish to change and choose your file. Then, click upload. The page will refresh indicating the change.
                You can also change the homepage text by changing desired text and then clicking change. Changes are immediate.</p>
              <h2 class="text-center">Logout</h2>
              <p>This logs you out of the administrative dashboard and brings you to the homepage.</p>
              <h2 class="text-center">About</h2>
              <p>Allows you to change the about page. Drag and drop a photo in the box to change the photo. Changes should occur
                immediately. Clicking the edit text button allows you to change the paragraph structure using the built in
                text editor. Clicking confirm will save changes, cancel will cancel.
              </p>
              <h2 class="text-center">FAQ</h2>
              <p>This lets you add, edit, rearrage, or delete FAQ sections. Click '+' to add new FAQ and edit. Click trash or
                pencil to delete or edit and reorder to reorder via drag and drop.</p>
              <h2 class="text-center">Photos, Accolades, and Videos</h2>
              <p>
                This allows you to add content to the site under the main 3 sections. The layout is mostly the same, with a few differences.
                When clicked, you will be presented with the files that are currently uploaded to the site. You can click
                the pencil icon to edit the title, caption, or year of the specified element. To save those changes, click
                the check box. Otherwise, click the 'X'. A message will appear telling you whether the operation was successful
                or not. Changes will be immediately apparent in the dashboard and on the site. To delete an item, click the
                trash can. A confirmation dialog will pop up asking you if you really want to delete. You can also add new
                items to each of the sections. Click the '+' to add an item. For photos, a box will appear and you can drag
                and drop photos there. They will appear in the table immediately. You can then edit the details with the
                pencil icon. For videos, a text box will appear. You then paste a YouTube link into the box and click submit.
                It adds the thumbnail of the video automatically. You have to fill in the title, caption, and year. Accolades
                combines the two. If you click add, you can choose to upload a photo or video. The same respective things
                will show depending on what you choose. You can also reorder all files you have uploaded so they show in
                a different order on their pages. Simply click reorder and you can drag and drop whole rows to change the
                order. Once done, click save order to save the order.
              </p>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>

    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
      window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')
    </script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/dash.js?v1.0.0.1"></script>
    <script src="../js/tinymce/tinymce.min.js"></script>
    <script src="../js/tinymce/jquery.tinymce.min.js"></script>
    <script src="../js/tinymce/jquery.tinymce.min.js"></script>
    <script src="../js/dropzone.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
</body>

</html>