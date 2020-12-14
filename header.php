
<div class="container-fluid">
    <div class="row">
    <div class="col-sm-12">
        <br>
    <center> 
       <a href="index.php"> <img src="media/ugflagextrasmall.png"></a>
        <br>
        <a href="index.php"><h3><b>Mukono General Hospital</b></h3></a>
        <h5>Republic of Uganda</h5>
        <div class="header-time">,  <?php echo date(" M d Y");?></div>
<div class="header-time"id="txt"></div>
        </center>
        </div>
        
    </div>

</div>
    
<script>
    
function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('txt').innerHTML =
  h + ":" + m + ":" + s;
  var t = setTimeout(startTime, 500);
}
function checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
}
    startTime();
</script>
    <style>
        .header-time{
            float:right;
            font-size: 13px;
            color:green;
        }
</style>