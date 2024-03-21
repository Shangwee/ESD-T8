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

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  <!-- Custom styles for this template -->
  <link href="../css/common.css" rel="stylesheet" />
  <link href="../css/dashboard.css" rel="stylesheet" />
</head>

<body>
  <div id="protect">
  </div>
  <div id="profile">
    <?php
    //  SVG icon for the navbar
    require_once("./common/svg.php");
    //start of NavBar
    require_once("./common/navbar.php");
    ?>

    <div class="container-fluid">
      <div class="row">
        <!-- start of side bar -->
        <?php
        require_once("./common/sidebar.php");
        ?>

        <!-- Start of Main page -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <div class="container mt-5">
              <h1 class="mb-4">Patient Profile</h1>
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">User Information</h5>
                  <p class="card-text"><strong>Name:</strong> John Doe</p>
                  <p class="card-text"><strong>Email:</strong> johndoe@example.com</p>
                  <p class="card-text"><strong>Phone:</strong> 123-456-7890</p>
                  <p class="card-text"><strong>Address:</strong> 123 Main St, City, Country</p>
                  <a href="#" class="btn btn-primary">Edit Profile</a>
                </div>
              </div>
              <div class="mt-4">
                <h3>Prescriptions</h3>
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Prescription ID</th>
                      <th scope="col">Medication</th>
                      <th scope="col">Dosage</th>
                      <th scope="col">Instructions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">1</th>
                      <td>Medication A</td>
                      <td>1 pill per day</td>
                      <td>Take with food</td>
                    </tr>
                    <tr>
                      <th scope="row">2</th>
                      <td>Medication B</td>
                      <td>2 pills per day</td>
                      <td>Take in the morning</td>
                    </tr>
                    <tr>
                      <th scope="row">3</th>
                      <td>Medication C</td>
                      <td>1 pill per day</td>
                      <td>Take before bedtime</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

        </main>
        <!-- end of Mainpage -->
      </div>
    </div>
  </div>
  <!-- scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
  <script src="../js/profile.js"></script>
  <script src="../js/protect.js"></script>
</body>

</html>