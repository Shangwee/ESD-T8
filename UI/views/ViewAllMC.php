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
    <style>
        .tablebord{
          border-width: 2px !important;
        }
    </style>
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
            <!-- <h1 class="h2" style="text-align:center !important;">MC CERTIFICATION</h1> -->
          </div>
          <div id="mc">
              <div v-if="listofMC.length>0">
                <table v-for="(mc,ind) in listofMC" :key="ind" class="border border-top border-bottom mb-5 tablebord" style="width:100%">
                  <th colspan="2" class="ps-5 fs-3 fw-bold pt-4 pb-4" style="text-decoration:underline; color:blue;">Medical Certification</th>
                    <tr>
                        <td class="fs-5 ps-5 pt-4"><strong>Name:</strong> &nbsp;{{mc.patientname}}</td>
                        <!-- <td class="pt-4 fs-5">/td> -->
                    </tr>
                    <tr>
                        <!-- <tr>
                            <td colspan="2" class="text-center"><hr style="width: 100%;"></td>
                        </tr> -->
                        <td colspan="2" class="px-5 py-3" style="padding-top:30px;"><br>This is to certify that the person is unfit for for duty for a period of {{mc.numberofdays}} days from {{mc.date}} to {{mc.newdate}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="px-5 py-5 pt-4"><strong>Remarks:</strong> &nbsp; This person is medically unfit</td>
                    </tr>
                    <tr>
                        <td class="px-5 py-5" colspan="">Date: {{mc.date}}</td>
                        <td class="px-5 py-1">Signature: <img class="img-fluid" style="max-width: 20%; height: auto;" src="../images/Signature.jpeg"></td>
                    </tr>
                    
                </table>
                <br>
              </div>
              <div v-else>
                  No MC record found
              </div>
          </div>
            
        </main>
        <!-- end of Mainpage -->
      </div>
    </div>
    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
    <script>

      url = "http://localhost:5008/mc/retrievalofsinglerecord/2"
     
   

    </script>
      <script src="../js/ViewAllMC.js"></script>
      <!-- <script src="../js/protect.js"></script> -->
      <!-- FIX THIS LATER -->
      <script>
            var MCURL = 'http://localhost:5008/mc/retrieveonpatientid';  
            const app = Vue.createApp({
                data() {
                    return {
                        id: '',
                        listofMC: [],
                        
                    }
                },

            methods: {
              displayPatient(){
                // get account from session storage
                let account = JSON.parse(sessionStorage.getItem('account'));
                this.id = account.id;
                this.name = account.name;  
              },
              getAllMC() {
                    const dateformat = (dateString) => {
                        const date = new Date(dateString);
                        const d = ('0' + date.getDate()).slice(-2);
                        const m = ('0' + (date.getMonth() + 1)).slice(-2);
                        const y = date.getFullYear();
                        return `${d}/${m}/${y}`;
                    };

                    axios.get(MCURL + '/' + this.id).then((response) => {
                        var allmc = response.data.data.mc;
                        
                        for (let mc of allmc) {
                            console.log(mc);
                            console.log(mc.assigned);
                            if (mc.date) {
                                mc.date = dateformat(mc.date);
                            }
                            if (mc.newdate) {
                                mc.newdate = dateformat(mc.newdate);
                            }
                      }

                      this.listofMC = allmc;
                      console.log(this.listofMC);
                  });
            }
        },
        created() {
            this.displayPatient()
            this.getAllMC();
        }
            }); 

            app.mount('#mc');
      </script>
  </body>
</html>
