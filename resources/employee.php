<?php
require_once("dbconfig.php");
try
{
    $action = $_POST['action'];
    switch($action)
    {
        case "rooms":
            $sql = "Select a.*,b.*,FORMAT(b.Rate,2)Rate,c.Description as Category from tblavailableroom a LEFT JOIN tblrooms b ON b.roomID=a.roomID LEFT JOIN tblcategory c ON c.catID=b.catID GROUP BY a.aID";
            $stmt=$dbh->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                if($row['Status']==1)
                {
                    ?>
                    <tr>
                        <td><?php echo $row['Category'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Description'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td><span class='badge bg-primary'> Operational</span></td>
                    </tr>
                    <?php
                }
                else
                {
                    ?>
                    <tr>
                        <td><?php echo $row['Category'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Description'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td><span class='badge bg-danger'> Under-maintenance</span></td>
                    </tr>
                    <?php
                }
            }
            break;
        case "search-rooms":
            $text = "%".$_POST['keyword']."%";
            $sql = "Select a.*,b.*,FORMAT(b.Rate,2)Rate,c.Description as Category from tblavailableroom a LEFT JOIN tblrooms b ON b.roomID=a.roomID LEFT JOIN tblcategory c ON c.catID=b.catID 
            WHERE b.Name LIKE :text GROUP BY a.aID";
            $stmt=$dbh->prepare($sql);
            $stmt->bindParam(':text',$text);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                if($row['Status']==1)
                {
                    ?>
                    <tr>
                        <td><?php echo $row['Category'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Description'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td><span class='badge bg-primary'> Operational</span></td>
                    </tr>
                    <?php
                }
                else
                {
                    ?>
                    <tr>
                        <td><?php echo $row['Category'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Description'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td><span class='badge bg-danger'> Under-maintenance</span></td>
                    </tr>
                    <?php
                }
            }
            break;
        case "reservation":
            $sql = "Select d.Fullname,a.*,FORMAT(a.TotalRate,2)charge,b.RoomNumber,c.Name,c.Description,FORMAT(c.Rate,2)Rate from tbltransaction a LEFT JOIN tblavailableroom b ON a.aID=b.aID 
            LEFT JOIN tblrooms c ON c.roomID=b.roomID LEFT JOIN tblcustomer d ON a.customerID=d.customerID WHERE d.Customer_type IN ('Online','Walk-In') GROUP BY a.trxnID ORDER BY a.trxnID DESC";
            $stmt=$dbh->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                if($row['Remarks']=="UnPaid")
                {
                    ?>
                    <tr>
                        <td><?php echo $row['Fullname'] ?></td>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['FromDate'] ?></td>
                        <td><?php echo $row['ToDate'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['charge'] ?></td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btn-sm accept" value="<?php echo $row['trxnID'] ?>"> Accept</button>&nbsp;
                            <button type="button" class="btn btn-outline-danger btn-sm ignore" value="<?php echo $row['trxnID'] ?>"> Cancel</button>
                        </td>
                    </tr>
                    <?php
                }
                else
                {
                    ?>
                    <tr>
                        <td><?php echo $row['Fullname'] ?></td>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['FromDate'] ?></td>
                        <td><?php echo $row['ToDate'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['charge'] ?></td>
                        <td><?php echo $row['Remarks'] ?></td>
                    </tr>
                    <?php
                }
            }
            break;
        case "search-reservation":
            $text = "%".$_POST['keyword']."%";
            $sql = "Select d.Fullname,a.*,FORMAT(a.TotalRate,2)charge,b.RoomNumber,c.Name,c.Description,FORMAT(c.Rate,2)Rate from tbltransaction a LEFT JOIN tblavailableroom b ON a.aID=b.aID 
            LEFT JOIN tblrooms c ON c.roomID=b.roomID LEFT JOIN tblcustomer d ON a.customerID=d.customerID WHERE d.Fullname LIKE :text AND d.Customer_type IN ('Online','Walk-In') GROUP BY a.trxnID ORDER BY a.trxnID DESC";
            $stmt=$dbh->prepare($sql);
            $stmt->bindParam(':text',$text);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                if($row['Remarks']=="UnPaid")
                {
                    ?>
                    <tr>
                        <td><?php echo $row['Fullname'] ?></td>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['FromDate'] ?></td>
                        <td><?php echo $row['ToDate'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['charge'] ?></td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btn-sm accept" value="<?php echo $row['trxnID'] ?>"> Accept</button>&nbsp;
                            <button type="button" class="btn btn-outline-danger btn-sm ignore" value="<?php echo $row['trxnID'] ?>"> Cancel</button>
                        </td>
                    </tr>
                    <?php
                }
                else
                {
                    ?>
                    <tr>
                        <td><?php echo $row['Fullname'] ?></td>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['FromDate'] ?></td>
                        <td><?php echo $row['ToDate'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['charge'] ?></td>
                        <td><?php echo $row['Remarks'] ?></td>
                    </tr>
                    <?php
                }
            }
            break;
        case "available":
            $sql = "Select a.aID,a.RoomNumber,a.Remarks,b.Name,b.Description,FORMAT(b.Rate,2)Rate,a.NumberOfBed from tblavailableroom a LEFT JOIN tblrooms b ON a.roomID=b.roomID WHERE a.Status=1 AND a.NumberOfBed<> 0 GROUP BY a.aID ORDER BY a.Remarks";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            $output="";
            $output.="<div class='row'>";
            foreach($data as $row)
            {
                    $output.=   "<div class='col-lg-4'>
                                    <div class='card bg-success'>
                                        <div class='card-block'>
                                            <div class='row'>
                                                <div class='col-md-12 form-group'> Room No. : ".$row['RoomNumber']."</div>
                                                <div class='col-md-12 form-group'> ".$row['Name']."</div>
                                                <div class='col-md-12 form-group'>
                                                    <label>Description</label>
                                                    <textarea class='form-control'>".$row['Description']."</textarea>
                                                </div>
                                                <div class='col-md-12 form-group'>
                                                    <label>Available Bed</label>
                                                    <input type='text' class='form-control' value='".$row['NumberOfBed']."'/>
                                                </div>
                                                <div class='col-md-12 form-group'>
                                                    <label>Rate Per Month</label>
                                                    <input type='text' class='form-control' value='PHP ".$row['Rate']."'/>
                                                </div>
                                                <div class='col-md-12 form-group'>
                                                    <center>
                                                    <button type='button' class='btn btn-primary form-control reserve' value='".$row['aID']."'> Choose </button>
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
            }
            $output.="</div>";
            echo $output;
            break;
        case "search-available":
            $name = $_POST['name'];
            $sql = "Select a.aID,a.RoomNumber,a.Remarks,b.Name,b.Description,FORMAT(b.Rate,2)Rate,a.NumberOfBed from tblavailableroom a LEFT JOIN tblrooms b ON a.roomID=b.roomID WHERE a.Status=1 AND a.NumberOfBed<> 0 AND b.roomID=:id GROUP BY a.aID ORDER BY a.Remarks";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id',$name);
            $stmt->execute();
            $data = $stmt->fetchAll();
            $output="";
            $output.="<div class='row'>";
            foreach($data as $row)
            {
                    $output.=   "<div class='col-lg-4'>
                                    <div class='card bg-success'>
                                        <div class='card-block'>
                                            <div class='row'>
                                                <div class='col-md-12 form-group'> Room No. : ".$row['RoomNumber']."</div>
                                                <div class='col-md-12 form-group'> ".$row['Name']."</div>
                                                <div class='col-md-12 form-group'>
                                                    <label>Description</label>
                                                    <textarea class='form-control'>".$row['Description']."</textarea>
                                                </div>
                                                <div class='col-md-12 form-group'>
                                                    <label>No. Bed</label>
                                                    <input type='text' class='form-control' value='".$row['NumberOfBed']."'/>
                                                </div>
                                                <div class='col-md-12 form-group'>
                                                    <label>Rate Per Month</label>
                                                    <input type='text' class='form-control' value='PHP ".$row['Rate']."'/>
                                                </div>
                                                <div class='col-md-12 form-group'>
                                                    <center>
                                                    <button type='button' class='btn btn-primary form-control reserve' value='".$row['aID']."'> Choose </button>
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                
            }
            $output.="</div>";
            echo $output;
            break;
        case "category":
            $sql = "Select catID,Description from tblcategory";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                echo "<option value='".$row['catID']."'>".$row['Description']."</option>";
            }
            break;
        case "get":
            $text = $_POST['category'];
            $sql = "Select roomID,Name from tblrooms WHERE catID=:id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id',$text);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                echo "<option value='".$row['roomID']."'>".$row['Name']."</option>";
            }
            break;
        case "taken";
            $id = $_POST['id'];
            $sql = "update tbltransaction SET Remarks='Paid' WHERE trxnID=:id";
            $stmt=$dbh->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            
            $stmt=$dbh->prepare("Select b.RoomNumber from tblavailableroom b LEFT JOIN tbltransaction a ON a.aID=b.aID WHERE a.trxnID=:id");
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                $room = $row['RoomNumber'];
                $stmt=$dbh->prepare("update tblavailableroom SET Remarks='Occupied' WHERE RoomNumber=:room");
                $stmt->bindParam(':room',$room);
                $stmt->execute();
            }
            echo "success";
            break;
        case "cancel":
            $id = $_POST['trxn'];
            $sql = "update tbltransaction SET Remarks='Cancelled' WHERE trxnID=:id";
            $stmt=$dbh->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $stmt=$dbh->prepare("Select b.RoomNumber from tblavailableroom b LEFT JOIN tbltransaction a ON a.aID=b.aID WHERE a.trxnID=:id");
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                $room = $row['RoomNumber'];
                $stmt=$dbh->prepare("update tblavailableroom SET Remarks='Available' WHERE RoomNumber=:room");
                $stmt->bindParam(':room',$room);
                $stmt->execute();
            }
            echo "Successfully cancelled!";
            break;
        case "Pay":
            $date = date("Y-m-d");
            $id = $_POST['trxn'];
            $month = $_POST['month'];
            $total = $_POST['total'];
            $newtotal = str_replace( ',', '', $total);
            $pay = $_POST['pay'];
            $change = $_POST['change'];
            
            //update 
            $stmt=$dbh->prepare("update tbltransaction SET Remarks='Paid' WHERE trxnID=:id");
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            
            //generate reference code
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
            
            $code = random_int(1000000000, 9999999999);
            //save the original records
            $sql = "insert into tblpayment(trxnID,TotalCharge,Month,Pay_Amount,QRCode)values(:id,:total,:month,:pay,:code)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->bindParam(':total',$newtotal);
            $stmt->bindParam(':month',$month);
            $stmt->bindParam(':pay',$pay);
            $stmt->bindParam(':code',$code);
            $stmt->execute();
            
            $newMonth = $month-2;
            //save the accumulating process of payment
            $stmt = $dbh->prepare("insert into tbl_bill(QRCode,TotalCharge,Month,Pay_Amount,Change_Amount,Date,Reference)values(:code,:total,:month,:pay,:change,:date,:reference)");
            $stmt->bindParam(':code',$code);
            $stmt->bindParam(':total',$newtotal);
            $stmt->bindParam(':month',$newMonth);
            $stmt->bindParam(':pay',$pay);
            $stmt->bindParam(':change',$change);
            $stmt->bindParam(':date',$date);
            $stmt->bindParam(':reference',$reference);
            $stmt->execute();
            echo "success";
            break;
        case "customer":
            $sql = "Select a.RoomNumber,b.*,c.Fullname,d.Name,f.Change_Amount as bal from tblavailableroom a LEFT JOIN tbltransaction b ON b.aID=a.aID 
            LEFT JOIN tblcustomer c ON c.customerID=b.customerID LEFT JOIN tblrooms d ON d.roomID=a.roomID LEFT JOIN tblpayment e ON e.trxnID=b.trxnID 
            LEFT JOIN (Select billID,QRCode,Change_Amount from tbl_bill ORDER BY billID DESC LIMIT 1) f ON f.QRCode=e.QRCode
            WHERE b.Remarks='Paid' GROUP BY b.trxnID";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                if($row['bal']>0)
                {
                    ?>
                    <tr>
                        <td><?php echo $row['Fullname'] ?></td>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['FromDate'] ?></td>
                        <td><?php echo $row['ToDate'] ?></td>
                        <td>-</td>
                    </tr>
                    <?php
                }
                else
                {
                    ?>
                    <tr>
                        <td><?php echo $row['Fullname'] ?></td>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['FromDate'] ?></td>
                        <td><?php echo $row['ToDate'] ?></td>
                        <td><button type="button" class="btn btn-outline-primary btn-sm checkout" value="<?php echo $row['trxnID'] ?>"> Check-out</button></td>
                    </tr>
                    <?php
                }
            }
            break;
        case "search-customer":
            $text = "%".$_POST['keyword']."%";
            $sql = "Select a.RoomNumber,b.*,c.Fullname,d.Name from tblavailableroom a LEFT JOIN tbltransaction b ON b.aID=a.aID 
            LEFT JOIN tblcustomer c ON c.customerID=b.customerID LEFT JOIN tblrooms d ON d.roomID=a.roomID LEFT JOIN tblpayment e ON e.trxnID=b.trxnID 
            LEFT JOIN (Select billID,QRCode,Change_Amount from tbl_bill ORDER BY billID DESC LIMIT 1) f ON f.QRCode=e.QRCode 
            WHERE b.Remarks='Paid' AND a.RoomNumber LIKE :text GROUP BY b.trxnID";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':text',$text);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                if($row['bal']>0.00)
                {
                    ?>
                    <tr>
                        <td><?php echo $row['Fullname'] ?></td>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['FromDate'] ?></td>
                        <td><?php echo $row['ToDate'] ?></td>
                        <td>-</td>
                    </tr>
                    <?php
                }
                else
                {
                    ?>
                    <tr>
                        <td><?php echo $row['Fullname'] ?></td>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['FromDate'] ?></td>
                        <td><?php echo $row['ToDate'] ?></td>
                        <td><button type="button" class="btn btn-outline-primary btn-sm checkout" value="<?php echo $row['trxnID'] ?>"> Check-out</button></td>
                    </tr>
                    <?php
                }
            }
            break;
        case "check-out":
            $id = $_POST['id'];
            $sql = "update tbltransaction SET Remarks='Check-out' WHERE trxnID=:id";
            $stmt=$dbh->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $stmt=$dbh->prepare("Select b.RoomNumber,a.Bed,b.NumberOfBed from tblavailableroom b LEFT JOIN tbltransaction a ON a.aID=b.aID WHERE a.trxnID=:id");
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                $room = $row['RoomNumber'];
                $total = $row['NumberOfBed']+$row['Bed'];
                $stmt=$dbh->prepare("update tblavailableroom SET NumberOfBed=:bed WHERE RoomNumber=:room");
                $stmt->bindParam(':bed',$total);
                $stmt->bindParam(':room',$room);
                $stmt->execute();
            }
            echo "Successfully check out!";
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