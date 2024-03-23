<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <title>Health Management Hub</title>

    <!-- js script -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

    <!-- CSS/BootStrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

    <!-- Custom styles for this template -->
    <!-- <link href="../css/dashboard.css" rel="stylesheet" />
    <link href="../css/common.css" rel="stylesheet" /> -->
    <style>
        .cusborder{
          border: 3px solid #2d5db1;
        }
    </style>
  </head>

  <body>
    <!-- SVG icon for the navbar -->
    <!-- <div id="protect">
    </div> -->
    <div class=" p-5 mb-4 rounded-3" style="background-color:#2d5db1;">
    <?php 
        require_once("./common/patientnav.php");
    ?>
    <div class="container-fluid py-5" style="min-height: 500px;">
        <div class="row">
            <div class="col-md-6 align-self-center">
                <h1 class="display-5 fw-bold text-white">Experienced Doctors</h1>
                <p class="fs-4 text-white">
                    Discover a haven of healing at our modern clinic, where compassionate care meets state-of-the-art facilities. Experience personalized healthcare in a welcoming environment, tailored to meet your unique needs.
                </p>
            </div>
            <div class="col-md-6">
                <img src="../images/patient.png" class="img-fluid" alt="Patient Image">
            </div>
        </div>
    </div>
</div>
<div class="container my-5">
  <div class="row g-3">
    <!-- Card 1 -->
    <div class="col-md-4">
      <div class="card p-3 rounded shadow">
        <div class="card-body text-center">
          <div class="card-title">
            <img src="path_to_icon" alt="" class="mb-4">
            <h5>True Care</h5>
          </div>
          <p class="card-text">We have professional doctors that can cater to you 24/7. Just come online and we can find you the best doctor in the world.</p>
          <a href="#" class="btn rounded-pill cusborder">Learn More</a>
          <p></p>
          <p></p>
        </div>
      </div>
    </div>
    <!-- Card 2 -->
    <div class="col-md-4">
      <div class="card p-3 rounded shadow" >
        <div class="card-body text-center">
          <div class="card-title">
            <img src="path_to_icon" alt="" class="mb-4">
            <h5>Experienced Personnel</h5>
          </div>
          <p class="card-text">Our doctor have credited certifications from renowned instituitions and have a bag of experience under their belt.  </p>
          <a href="#" class="btn  rounded-pill cusborder">Learn More</a>
          <p></p>
          <p></p>
        </div>
      </div>
    </div>
    <!-- Card 3 -->
    <div class="col-md-4">
      <div class="card p-3 rounded shadow">
        <div class="card-body text-center">
          <div class="card-title">
            <img src="path_to_icon" alt="" class="mb-4">
            <h5>Available 24/7</h5>
          </div>
          <p class="card-text">We are available any time of the day. Just visit our website at www.mediheal.com and you will experience quality service.</p>
          <a href="#" class="btn rounded-pill cusborder">Learn More</a>
          <p></p>
          <p></p>
        </div>
      </div>
    </div>
  </div>
</div>




  
    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
   
      <script src="../js/protect.js"></script>
  </body>
</html>
