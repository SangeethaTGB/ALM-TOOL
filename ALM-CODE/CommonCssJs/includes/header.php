 
<style >
  

  @media print {
    .no_print, .sidebar{
      display: none;
    }    

  }
</style>
 <header class="header black-bg" style="background: green; outline: none; border-color: red;;  box-shadow : 5px 5px 10px black; ">
              <div class="sidebar-toggle-box"  style="color: white ! important" title="Toggle">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation">
                    
                  </div>
              </div>
            <!--logo start-->
            <div class="top-menu" style="display: flex; justify-content: space-around; ">
              <a><b><?php $pid=99999;// include $_SERVER['DOCUMENT_ROOT'] . '\mis\depNoCSS.php'; ?></b></a> 
              <a href="/mis/Departments/HeadOffice/ALM/" style="color: white"><h1>Asset and Liability Management (ALM)</h1></a>               
              <div style="float: right;display: flex;  ">             
                  <h5 class="centered"><?php echo "$EmpName ($pid)"; ?><br><?php echo "$branchname ($EmpBrcode)"; ?></h5>
                </div>

              <!--ul class="nav pull-right top-menu">
                    <li><a class="logout" href="logout.php">Logout</a></li>
              </ul-->
            </div>
              <?php //include $_SERVER['DOCUMENT_ROOT'] . '\mis\phpFunctions.php'; ?> 
              <?php include 'CommonCssJs\includes\number_to_text.php'; ?> 

       </header>