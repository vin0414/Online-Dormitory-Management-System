<?php
include("dbconfig.php");
try
{
    switch($_POST['action'])
    {
        case "paying-balance":
            $code = $_POST['code'];
            $date = date('Y-m-d');
            $total = $_POST['balance'];
            $bal = str_replace( ',', '', $total);
            $remain_month = $_POST['remain_month'];
            $month = $_POST['month'];
            $rem = $month-$remain_month;
            $amount = $_POST['amount'];
            $change = $_POST['change'];
            
            $reference="";
            $sql = "Select COUNT(billID)+1 total from tbl_bill";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $count = $stmt->rowCount();
            $list_codes   = $stmt->fetch(PDO::FETCH_ASSOC);
            if($count == 1 && !empty($list_codes))
            {
                $reference =  str_pad($list_codes['total'],7,0,STR_PAD_LEFT);
            }
            //insert
            $stmt = $dbh->prepare("insert into tbl_bill(QRCode,TotalCharge,Month,Pay_Amount,Change_Amount,Date,Reference)
            values(:code,:bal,:mm,:amt,:change,:date,:ref)");
            $stmt->bindParam(':code',$code);
            $stmt->bindParam(':bal',$bal);
            $stmt->bindParam(':mm',$rem);
            $stmt->bindParam(':amt',$amount);
            $stmt->bindParam(':change',$change);
            $stmt->bindParam(':date',$date);
            $stmt->bindParam(':ref',$reference);
            $stmt->execute();
            echo "success";
            break;
        default:
            break;
    }
}
catch(Exception $e)
{
    echo $e->getMessage();
}
$dbh=null;
?>