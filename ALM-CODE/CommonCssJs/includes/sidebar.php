
<?php
$adminIdsList=array(99999,2828,1498,1888,3352);
if (in_array($pid,$adminIdsList))
 $editId=1;
else
 $editId=0;

?>
<aside>
<div id="sidebar"  class="nav-collapse " style="overflow: auto">
    <!-- sidebar menu start-->
    <br>
    <ul class="sidebar-menu" id="nav-accordion">

<?php //var_dump($adminIdsList); ?>
        <li  class="sub-menu" >
            <a > <b style="font-size:1.5em" >&#9878;</b> <span> ALM</span> <div class="dcjq-icon"></div> </a>
            <ul>
            	<li class="sub-menu">
                    <a href="Trend.php">Trend Analysis</a>  
                </li>               
                <li class="sub-menu">
                    <a href="View_Statement.php">View Statement</a> 
                </li>
                <?php if (in_array($pid,$adminIdsList)) : ?>
            	<li class="sub-menu">
                    <a href="ALM_Load.php">Load Data - Admin</a> 
                </li>    
                <?php endif; ?>           
            </ul>
        </li>

        <li  class="sub-menu" >
            <a > <b style="font-size:1.5em" >&#128185;</b> <span> Investments</span> </a>
            <ul>
              <li>
               <a href="Bond_Display.php">Bonds</a>
              </li>
              <li>
               <a href="SLR_Display1.php">SLR</a>
              </li>
              <li>
               <a href="MF_Display.php">Mutual Funds</a>
              </li>
              <li>
               <a href="TDR_Display.php">TDRs</a>
              </li>
            </ul>
        </li>

        <li  class="sub-menu" >
            <a href="CA_Display.php"><b style="font-size:1.5em" >&#9940;</b> Current Accounts</a>
        </li>

        <li  class="sub-menu" >
            <a href="http://10.88.1.112/Refinance/Outstanding.php" target="_blank"><b style="font-size:1.5em" >&#128176;</b> Refinances</a>
        </li>

<!--         <li  class="sub-menu" >
            <a href="/Investments/dashboard.php" target="_blank"><b style="font-size:1.5em" >&#128176;</b> Investments</a>
        </li> -->
        <li  class="sub-menu" >
<!--             <a href="http://10.88.1.112/Balance_Sheet_Selection/" target="_blank"><b style="font-size:1.5em" >&#128181;</b> Balance Sheet</a> -->
            <a > <b style="font-size:1.5em" >&#128185;</b> <span> Balance Sheet</span> </a>
            <ul>
              <li>
               <a href="compileBalanceSheet.php"><b style="font-size:1.5em" >&#9940;</b> compile</a>
               <a href="ShowDailyBS.php"><b style="font-size:1.5em" >&#9940;</b> View</a>
              </li>
            </ul>
        </li>
<!--         <li class="sub-menu">
            <a href="http://10.88.1.76/MCLR1/MCLR_loan.php" target="_blank" ><b style="font-size:1.5em" >&#9997;</b> MCLR</a>  
        </li> -->
        <li class="sub-menu">
            <a href="ManualEntries.php"><b style="font-size:1.5em" >&#9997;</b> Reports</a>  
        </li>
              <!-- sidebar menu end-->
              
</ul>
            
          </div>
      </aside>
      
    
      

    <script  type="text/javascript" src="CommonCssJs/assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="CommonCssJs/assets/js/jquery.scrollTo.min.js"></script>
    <script src="CommonCssJs/assets/js/common-scripts.js"></script>