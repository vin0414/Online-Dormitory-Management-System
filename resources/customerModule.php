<?php
require_once("dbconfig.php");
try
{
    switch($_POST['action'])
    {
        case "rooms":
            $sql = "Select a.*,b.*,FORMAT(b.Rate,2)Rate from tblavailableroom a LEFT JOIN tblrooms b ON b.roomID=a.roomID WHERE a.NumberOfBed<> 0 AND a.Status=1 GROUP BY a.aID";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                ?>
                <tr>
                    <td><?php echo $row['Name'] ?></td> 
                    <td><?php echo $row['RoomNumber'] ?></td>
                    <td><?php echo $row['Description'] ?></td>
                    <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                    <td style="text-align:center;"><?php echo $row['NumberOfBed'] ?></td>
                    <td><button type="button" class="btn btn-outline-primary btn-sm reserve" value="<?php echo $row['aID'] ?>"> Choose</button></td>
                </tr>
                <?php
            }
            break;
        case "search-rooms":
            $text = "%".$_POST['keyword']."%";
            $sql = "Select a.*,b.*,FORMAT(b.Rate,2)Rate from tblavailableroom a LEFT JOIN tblrooms b ON b.roomID=a.roomID WHERE a.NumberOfBed<> 0 AND a.Status=1 AND b.Name LIKE :text GROUP BY a.aID";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':text',$text);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                ?>
                <tr>
                    <td><?php echo $row['Name'] ?></td> 
                    <td><?php echo $row['RoomNumber'] ?></td>
                    <td><?php echo $row['Description'] ?></td>
                    <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                    <td style="text-align:center;"><?php echo $row['NumberOfBed'] ?></td>
                    <td><button type="button" class="btn btn-outline-primary btn-sm reserve" value="<?php echo $row['aID'] ?>">Choose</button></td>
                </tr>
                <?php
            }
            break;
        case "total":
            $id = $_POST['id'];
            $days = $_POST['days'];
            $sql = "Select b.Rate from tblavailableroom a LEFT JOIN tblrooms b on b.roomID=a.roomID WHERE a.aID=:id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                echo $row['Rate']*$days;
            }
            break;
        case "addtransaction":
            $customer = $_POST['customer'];
            $room = $_POST['roomID'];
            $fdate = $_POST['fdate'];
            $tdate = $_POST['tdate'];
            $total = $_POST['total'];
            $bed = $_POST['bed'];
            $remarks = "UnPaid";
            if(empty($fdate)||empty($tdate)||empty($total)||empty($bed))
            {
                echo "Please fill in the form";
            }
            else
            {
                $stmt=$dbh->prepare("Select NumberOfBed from tblavailableroom where aID=:id");
                $stmt->bindParam(':id',$room);
                $stmt->execute();
                $check = $stmt->fetchAll();
                foreach($check as $number_of_bed)
                {
                    if($number_of_bed['NumberOfBed']< $bed)
                    {
                        echo "Sorry! Insufficient number of bed";
                    }
                    else
                    {
                        $sql = "insert into tbltransaction(customerID,aID,Bed,FromDate,ToDate,TotalRate,Remarks)values(:customer,:id,:bed,:fdate,:tdate,:total,:remarks)";
                        $stmt = $dbh->prepare($sql);
                        $stmt->bindParam(':customer',$customer);
                        $stmt->bindParam(':id',$room);
                        $stmt->bindParam(':bed',$bed);
                        $stmt->bindParam(':fdate',$fdate);
                        $stmt->bindParam(':tdate',$tdate);
                        $stmt->bindParam(':total',$total);
                        $stmt->bindParam(':remarks',$remarks);
                        $stmt->execute();
                        //update the tblavailableroom
                        $stmt = $dbh->prepare('Select NumberOfBed from tblavailableroom WHERE aID=:id');
                        $stmt->bindParam(':id',$room);
                        $stmt->execute();
                        $data = $stmt->fetchAll();
                        foreach($data as $row)
                        {
                            $total = $row['NumberOfBed']-$bed;
                            $stmt = $dbh->prepare("update tblavailableroom SET NumberOfBed=:bed WHERE aID=:id");
                            $stmt->bindParam(':bed',$total);
                            $stmt->bindParam(':id',$room);
                            $stmt->execute();
                        }
                        echo "success";
                    }
                }
            }
            break;
        case "history":
            $customer = $_POST['customer']; 
            $sql = "Select a.*,FORMAT(a.TotalRate,2)Total,a.Remarks,b.RoomNumber,FORMAT(c.Rate,2)Rate,c.Name,c.Description,d.QRCode from tbltransaction a LEFT JOIN tblavailableroom b ON a.aID=b.aID LEFT JOIN tblrooms c ON c.roomID=b.roomID LEFT JOIN tblpayment d ON d.trxnID=a.trxnID WHERE a.customerID=:id GROUP BY a.trxnID";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id',$customer);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                if($row['Remarks']=='UnPaid')
                {
                    ?>
                    <tr>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['Description'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td><?php echo $row['FromDate'] ?></td>
                        <td><?php echo $row['ToDate'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Total'] ?></td>
                        <td><span class="badge bg-warning"> Reserved</span></td>
                        <td>-</td>
                    </tr>
                    <?php
                }
                else if($row['Remarks']=='Paid')
                {
                    ?>
                    <tr>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['Description'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td><?php echo $row['FromDate'] ?></td>
                        <td><?php echo $row['ToDate'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Total'] ?></td>
                        <td><span class="badge bg-success"> Taken</span></td>
                        <td><button type="button" class="btn btn-outline-primary view" value="<?php echo $row['QRCode'] ?>"> View QR Code</button></td>
                    </tr>
                    <?php
                }
                else if($row['Remarks']=='Check-out')
                {
                    ?>
                    <tr>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['Description'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td><?php echo $row['FromDate'] ?></td>
                        <td><?php echo $row['ToDate'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Total'] ?></td>
                        <td><span class="badge bg-success"> <?php echo $row['Remarks'] ?></span></td>
                        <td>-</td>
                    </tr>
                    <?php
                }
                else
                {
                    ?>
                    <tr>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['Description'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td><?php echo $row['FromDate'] ?></td>
                        <td><?php echo $row['ToDate'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Total'] ?></td>
                        <td><span class="badge bg-danger"> <?php echo $row['Remarks'] ?></span></td>
                        <td>-</td>
                    </tr>
                    <?php
                }
            }
            break;
        case "search-history":
            $customer = $_POST['customer']; 
            $text = "%".$_POST['keyword']."%";
            $sql = "Select a.*,FORMAT(a.TotalRate,2)Total,a.Remarks,b.RoomNumber,FORMAT(c.Rate,2)Rate,c.Name,c.Description,d.QRCode from tbltransaction a LEFT JOIN tblavailableroom b ON a.aID=b.aID LEFT JOIN tblrooms c ON c.roomID=b.roomID LEFT JOIN tblpayment d ON d.trxnID=a.trxnID WHERE a.customerID=:id AND c.Name LIKE :text GROUP BY a.trxnID";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id',$customer);
            $stmt->bindParam(':text',$text);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                if($row['Remarks']=='UnPaid')
                {
                    ?>
                    <tr>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['Description'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td><?php echo $row['FromDate'] ?></td>
                        <td><?php echo $row['ToDate'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Total'] ?></td>
                        <td><span class="badge bg-warning"> Reserved</span></td>
                        <td>-</td>
                    </tr>
                    <?php
                }
                else if($row['Remarks']=='Paid')
                {
                    ?>
                    <tr>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['Description'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td><?php echo $row['FromDate'] ?></td>
                        <td><?php echo $row['ToDate'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Total'] ?></td>
                        <td><span class="badge bg-success"> Taken</span></td>
                        <td><button type="button" class="btn btn-outline-primary view" value="<?php echo $row['QRCode'] ?>"> View QR Code</button></td>
                    </tr>
                    <?php
                }
                else if($row['Remarks']=='Check-out')
                {
                    ?>
                    <tr>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['Description'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td><?php echo $row['FromDate'] ?></td>
                        <td><?php echo $row['ToDate'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Total'] ?></td>
                        <td><span class="badge bg-success"> <?php echo $row['Remarks'] ?></span></td>
                        <td>-</td>
                    </tr>
                    <?php
                }
                else
                {
                    ?>
                    <tr>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['Description'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td><?php echo $row['FromDate'] ?></td>
                        <td><?php echo $row['ToDate'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Total'] ?></td>
                        <td><span class="badge bg-danger"> <?php echo $row['Remarks'] ?></span></td>
                        <td>-</td>
                    </tr>
                    <?php
                }
            }
            break;
        case "upload":
            $customer = $_POST['customer'];
            //files
            $name=$_FILES['profile']['name'];
            $size=$_FILES['profile']['size'];
            $type=$_FILES['profile']['type'];
            $temp=$_FILES['profile']['tmp_name'];
            $filename = date("YmdHis").'_'.$name;
            
            $date = date('Y-m-d');
            $stmt = $dbh->prepare("Select customerID from tblprofile WHERE customerID=:customer");
            $stmt->bindParam(':customer',$customer);
            $stmt->execute();
            $count = $stmt->rowCount();
            $row   = $stmt->fetch(PDO::FETCH_ASSOC);
            if($count == 1 && !empty($row))
            {
                //delete
                $stmt = $dbh->prepare("delete from tblprofile WHERE customerID=:customer");
                $stmt->bindParam(':customer',$customer);
                $stmt->execute();
                //insert
                $move =  move_uploaded_file($temp,"pictures/".$filename);
                    //insert into table tblwork_task
                $sql = "insert into tblprofile(customerID,File,Date)values(:customer,:file,:date)";
                $stmt=$dbh->prepare($sql);
                $stmt->bindParam(':customer',$customer);
                $stmt->bindParam(':file',$filename);
                $stmt->bindParam(':date',$date);
                $stmt->execute();
                echo "success";
            }
            else
            {
                $move =  move_uploaded_file($temp,"pictures/".$filename);
                    //insert into table tblwork_task
                $sql = "insert into tblprofile(customerID,File,Date)values(:customer,:file,:date)";
                $stmt=$dbh->prepare($sql);
                $stmt->bindParam(':customer',$customer);
                $stmt->bindParam(':file',$filename);
                $stmt->bindParam(':date',$date);
                $stmt->execute();
                echo "success";
            }
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