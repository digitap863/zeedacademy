<!DOCTYPE html>
<html lang="zxx">
<?php
require('../api/helpers/connection.php');
if (!isset($_SESSION['admin_id'])) {
  header("Location:index.php");
}
?>

<head>

  <!-- Metas -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="keywords" content="HTML5 Template Archo onepage themeforest" />
  <meta name="description" content="Archo - Onepage Multi-Purpose HTML5 Template" />
  <meta name="author" content="" />

  <!-- Title  -->
  <title>ZEED</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="../img/favicon.ico" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Teko:300,400,500,600,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,500,600,700,800,900&display=swap" rel="stylesheet">

  <!-- Plugins -->
  <link rel="stylesheet" href="../css/plugins.css" />

  <link href="../css/twentytwenty.css" rel="stylesheet" type="text/css" />

  <!-- Core Style Css -->
  <link rel="stylesheet" href="../css/style.css" />

</head>

<body>

  <style>
    .upload-card {
      display: flex;
      justify-content: center;
    }

    .gallery-item>div.card-body>img {
      /* height: 440px; */
    }
  </style>
  <!-- ==================== Start Loading ==================== -->

  <div id="preloader">
    <div class="loading-text">Loading</div>
  </div>

  <!-- ==================== End Loading ==================== -->


  <!-- ==================== Start progress-scroll-button ==================== -->

  <div class="progress-wrap cursor-pointer">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
  </div>

  <!-- ==================== End progress-scroll-button ==================== -->


  <!-- ==================== Start cursor ==================== -->

  <div class="mouse-cursor cursor-outer"></div>
  <div class="mouse-cursor cursor-inner"></div>

  <!-- ==================== End cursor ==================== -->


  <!-- ==================== Start Navbar ==================== -->

  <nav class="navbar change navbar-expand-lg">
    <div class="container">

      <!-- Logo -->
      <a class="logo" href="index.html">
        <img src="../img/logo-light.png" alt="logo">
      </a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="icon-bar"><i class="fas fa-bars"></i></span>
      </button>
      <div>
        <h2>Zeed Admin </h2>
      </div>

      <!-- navbar links -->
      <div class="social-icon">
        <a href="#" onclick="logOut()"><img src="../img/logout-removebg-preview (1) (1).png" alt="logo"></a>

      </div>
      <!-- <div class="search">
                        <span class="icon pe-7s-search cursor-pointer"></span>
                        <div class="search-form text-center custom-font">
                            <form>
                                <input type="text" name="search" placeholder="Search">
                            </form>
                            <span class="close pe-7s-close cursor-pointer"></span>
                        </div>
                    </div> -->
    </div>
    </div>
  </nav>

  <section class="portfolio section-padding">
    <div class="container">
      <div class="row upload-card mb-10">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Upload New Image (Multiple Images Supported)</h5>
              <div class="card-text">
                <div class="container">
                  <div class="row">
                    <div class="col-md-6">
                      <input type="file" name="image" id="image" multiple accept="image/*">
                    </div>
                    <div class="col-md-6">
                      <button type="button" class="btn btn-primary mt-4 ml-4" id="upload">
                        <i class="fa fa-upload"></i>
                        Upload
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="row gallery-preview">

      </div>
    </div>
  </section>
  <!-- jQuery -->
  <script src="../js/jquery-3.0.0.min.js"></script>
  <script src="../js/jquery-migrate-3.0.0.min.js"></script>

  <!-- plugins -->
  <script src="../js/plugins.js"></script>

  <!-- custom scripts -->
  <script src="scripts.js"></script>
  <script>
    $('#upload').on('click', function() {
      var totalFiles = document.getElementById('image').files.length;
      if (totalFiles) {
        var formData = new FormData()
        for (let i = 0; i < totalFiles; i++) {
          const el = $('#image').prop('files')[i];
          console.log(el);
          formData.append('image_' + (i + 1), document.getElementById('image').files[i])
        }
        $.ajax({
          url: "../api/uploadImage.php",
          data: formData,
          processData: false,
          contentType: false,
          type: 'POST',
          success: (res) => {
            console.log(res);
            if (!res.error) {
              getGallery()
            }
          }
        })
      } else {
        alert("Select Images")
      }
    })

    function getGallery() {
      $.ajax({
        url: '../api/listImageGallery.php',
        success: (res) => {
          let html = ``
          res.data.forEach(el => {
            html += `
            <div class='col-md-4 mb-5 image_` + el.id + `'>
              <div class='card gallery-item'>
                <div class='card-body'>
                  <img src="../upload/image_gallery/` + el.filename + `">
                  <button class='btn btn-danger mt-5' onclick='deleteImage(` + el.id + `)'>
                    <i class='fa fa-trash'></i>
                  </button>
                </div>
              </div>
            </div>
            `
          });
          $('.gallery-preview').html(html)
        }
      })
    }

    function deleteImage(id) {
      $.ajax({
        url: '../api/deleteImage.php',
        data: {
          id: id
        },
        success: (res) => {
          console.log(res);
          if (!res.error) {
            $('.image_' + id).remove()
          }
        },
        error: (err) => {
          console.error(err);
        }
      })
    }

    function logOut() {
      $.ajax({
        url: '../api/logout.php',
        success: (res) => {
          console.log(res);
          if (!res.error) {
            window.location.href = "index.php"
          }
        }
      })
    }

    getGallery()
  </script>
</body>

</html>