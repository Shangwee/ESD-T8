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
    <link href="../css/dashboard.css" rel="stylesheet" />
    <link href="../css/common.css" rel="stylesheet" />
  </head>

  <body>
    <!-- SVG icon for the navbar -->
    <!-- <div id="protect">
    </div> -->
    <?php 
    require_once("./common/svg.php"); 
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
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom text-center">
            <h1 class="h2" style="text-align:center !important;">MC CERTIFICATION</h1>
          </div>
            <table style="width:100%">
                <tr>
                    <td>Name:</td>
                    <td><span id="patientname"></td>
                </tr>
                <tr>
                    <!-- <td class="px-5 fs-6" colspan="2">&nbsp;&nbsp;&nbsp;<span id="patientname"></span></td> -->
                    <!-- <td class="px-5 fs-6">T0001175J</td> -->
                    <tr>
                        <td colspan="2" class="text-center"><hr style="width: 50%;"></td>
                    </tr>
                    <td colspan="2" class="px-5 py-3" style="padding-top:30px;"><br>This is to certify that the person is unfit for for duty for a period of <span id="numberofdays"></span> days from <span id="date"></span> to <span id="newdate"></span></td>
                </tr>
                <tr>
                    <td colspan="2" class="px-5 py-5">Remarks: </td>
                </tr>
                <tr>
                    <td class="px-5 py-5" colspan="">Date: <span id="newdisplaydate"></span></td>
                    <td class="px-5 py-1">Signature: <img class="img-fluid" style="max-width: 20%; height: auto;" src="../images/Signature.jpeg"></td>
                </tr>
                
            </table>
            
        </main>
        <!-- end of Mainpage -->
      </div>
    </div>
    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
    <script>

      url = "http://localhost:5008/mc/retrievalofsinglerecord/2"
     
      axios.get(url)
        .then(response => {
          console.log(response.data);
          const patientname = response.data.data.mc[0].patientname;
          const numberofdays = response.data.data.mc[0].numberofdays;

          const dt = new Date();
          date = dateformat(dt);
          console.log(date);
          let newdate = new Date(dt.getTime());
          newdate.setDate(newdate.getDate() + numberofdays - 1);
          newdate = dateformat(newdate);
          console.log(newdate);

          document.getElementById("patientname").textContent = patientname;
          document.getElementById("numberofdays").textContent = numberofdays;
          document.getElementById("date").textContent = date;
          document.getElementById("newdate").textContent = newdate;

          const displaydate =  new Date()
          const d = displaydate.getDate()
          const mi = displaydate.getMonth()
          const y = displaydate.getFullYear()

          const monthname = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
          const newdisplaydate = `${d} ${monthname[mi]} ${y}`;
          document.getElementById("newdisplaydate").textContent = newdisplaydate;
        })
        .catch(error => {
          console.error(error);
        });

      function dateformat(dateFormat) {
          const date = new Date(dateFormat);
          const day = date.getDate();
          const mth = date.getMonth() + 1; // Adjust for zero-based months
          const yr = date.getFullYear().toString().slice(-2);
          const newdate = `${day}/${mth}/${yr}`; // Use backticks for template literals
          return newdate;
      }

    </script>
      <script src="../js/protect.js"></script>
  </body>
</html>
