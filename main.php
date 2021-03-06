<form action="" method="post" class="row flex-nowrap">
    <div class="form-group col-3">
      <select name="year" class="custom-select">
        <option value="2019">2019</option>
        <option value="2020"selected>2020</option>
        <option value="2021">2021</option>
      </select>
    </div>
    <div class="form-group col-3">
      <select name="period" class="custom-select">
        <option value="1">01~02</option>
        <option value="2">03~04</option>
        <option value="3">05~06</option>
        <option value="4">07~08</option>
        <option value="5">09~10</option>
        <option value="6">11~12</option>
      </select>
    </div>
    <p class="text-center"><input type="submit" value="提交" class="py-1"></p>
</form>

<?php
include_once "./base.php";

if(isset($_POST['year']) && isset($_POST['period'])){
  $year=$_POST['year'];
  $period=$_POST['period'];
  $get_post=$pdo->query("SELECT * FROM `award_number` WHERE `year`='$year' && `period`='$period'")->fetch();
}else if(isset($_GET['pd'])){
  $year=explode('-',$_GET['pd'])[0];
  $period=explode('-',$_GET['pd'])[1];
}else{
  $year=date("Y");
  $period=(ceil(date("n")/2))-1;
  $get_new=$pdo->query("SELECT * FROM `award_number` WHERE `year`='$year' && `period`='$period'")->fetch();
  // if(empty($get_new)){
  //   echo "<table class='table table-sm'>";
  //   echo "<h1 style='text-align:center'>".$year."年 第".($period+1)."期 尚未開獎</h1>";
  //   echo "</table>";
  // }else{
    
  // }
}


$award=$pdo->query("SELECT * FROM `award_number` WHERE `year`='$year' && `period`='$period'")->fetchALL();
$special="";
$grand="";
$first=[];
$six=[];

foreach($award as $aw){
  switch($aw['type']){
    case 1:
      $special=$aw['number'];
    break;

    case 2:
      $grand=$aw['number'];
    break;

    case 3:
      $first[]=$aw['number'];
    break;

    case 4:
      $six[]=$aw['number'];
    break;
  }
}
?>
<table class="table table-sm " summary="統一發票中獎號碼單">
  <tbody>
    <tr> 
      <th id="month">年月份</th> 
      <td headers="month" class="title">
      <?php
        if($period<1){
          echo "<div class='ym'>";
        }else{
          echo "<div class='ym'>".$year."年";
        }
      ?>
      <?php
      $month=[
        0=>"no award",
        1=>"01~02",
        2=>"03~04",
        3=>"05~06",
        4=>"07~08",
        5=>"09~10",
        6=>"11~12"];
      if($period<1){
        echo "<table class='table table-sm'>";
        echo "<h1 style='text-align:center'>".$year."年 第".($period+1)."期 尚未開獎</h1>";
        echo "</table>";
      }else{
        echo $month[$period]."月";
      }
      ?>
      </div>
      </td>
    </tr>



    <tr> 
      <th id="specialPrize" rowspan="2">特別獎</th> 
      <td headers="specialPrize" class="number">
      <?=$special;?>
      </td> 
    </tr> 
    <tr> 
      <td headers="specialPrize"> 同期統一發票收執聯8位數號碼與特別獎號碼相同者獎金1,000萬元 </td> 
    </tr>

    <tr> 
      <th id="grandPrize" rowspan="2">特獎</th> 
      <td headers="grandPrize" class="number">
      <?=$grand;?>
      </td>
    </tr> 
    <tr> 
      <td headers="grandPrize"> 同期統一發票收執聯8位數號碼與特獎號碼相同者獎金200萬元 </td> 
    </tr>

    <tr> 
      <th id="firstPrize" rowspan="2">頭獎</th> 
      <td headers="firstPrize" class="number">
        <?php
          foreach($first as $f){
            echo $f."<br>";
          }
        ?>
      </td> 
    </tr> 
    <tr> 
      <td headers="firstPrize"> 同期統一發票收執聯8位數號碼與頭獎號碼相同者獎金20萬元 </td> 
    </tr>

    <tr hidden> 
      <th id="twoPrize">二獎</th> 
      <td headers="twoPrize"> 同期統一發票收執聯末7 位數號碼與頭獎中獎號碼末7 位相同者各得獎金4萬元 </td> 
    </tr> 
    <tr hidden> 
      <th id="threePrize">三獎</th> 
      <td headers="threeAwards"> 同期統一發票收執聯末6 位數號碼與頭獎中獎號碼末6 位相同者各得獎金1萬元 </td> 
    </tr> 
    <tr hidden> 
      <th id="fourPrize">四獎</th> 
      <td headers="fourPrizes"> 同期統一發票收執聯末5 位數號碼與頭獎中獎號碼末5 位相同者各得獎金4千元 </td> 
    </tr> 
    <tr hidden> 
      <th id="fivePrize">五獎</th> 
      <td headers="fivePrize"> 同期統一發票收執聯末4 位數號碼與頭獎中獎號碼末4 位相同者各得獎金1千元 </td> 
    </tr> 
    <tr hidden> 
      <th id="sixPrize">六獎</th> 
      <td headers="sixPrize"> 同期統一發票收執聯末3 位數號碼與 頭獎中獎號碼末3 位相同者各得獎金2百元 </td> 
    </tr>

    <tr> 
      <th id="addSixPrize">增開六獎</th> 
      <td headers="addSixPrize" class="number">
        <?php
          foreach($six as $s){
            echo $s."<br>";
          }
        ?>
      </td> 
    </tr> 
  </tbody>
</table>
