<?php
include("dbconfig.php");
try
{
    switch($_POST['action'])
    {
        case "inquire":
            $name = $_POST['name'];
            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $msg = $_POST['message'];
            $stat = 0;
            if(empty($name)||empty($email)||empty($subject)||empty($msg))
            {
                echo "Please fill in the form";
            }
            else
            {
                $sql = "insert into tblcontact(Fullname,EmailAddress,Subject,Message,Status)values(:name,:email,:subject,:msg,:stat)";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':name',$name);
                $stmt->bindParam(':email',$email);
                $stmt->bindParam(':subject',$subject);
                $stmt->bindParam(':msg',$msg);
                $stmt->bindParam(':stat',$stat);
                $stmt->execute();
                echo "success";
            }
            break;
        case "contact":
            $sql = "Select * from tblcontact";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                ?>
                <tr>
                    <td><?php echo $row['Fullname'] ?></td>
                    <td><?php echo $row['EmailAddress'] ?></td>
                    <td><?php echo $row['Subject'] ?></td>
                    <td><?php echo $row['Message'] ?></td>
                </tr>
                <?php
            }
            break;
        case "search-contact":
            $text = "%".$_POST['keyword']."%";
            $sql = "Select * from tblcontact WHERE Subject LIKE :text OR Fullname LIKE :text";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':text',$text);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                ?>
                <tr>
                    <td><?php echo $row['Fullname'] ?></td>
                    <td><?php echo $row['EmailAddress'] ?></td>
                    <td><?php echo $row['Subject'] ?></td>
                    <td><?php echo $row['Message'] ?></td>
                </tr>
                <?php
            }
            break;
        case "number_of_reserve":
            $sql = "Select COUNT(customerID)total from tbltransaction WHERE Remarks='UnPaid'";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                echo $row['total'];
            }
            break;
        case "paid":
            $sql = "Select COUNT(customerID)total from tbltransaction WHERE Remarks IN ('Paid','Check-out')";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                echo $row['total'];
            }
            break;
        case "room":
            $sql = "Select COUNT(RoomNumber)total from tblavailableroom WHERE Remarks='Available'";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                echo $row['total'];
            }
            break;
        case "income":
            $date = date("Y-m-d");
            $sql = "Select FORMAT(IFNULL(SUM(Pay_Amount),0),2)total from tbl_bill WHERE Date=:date";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':date',$date);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                echo $row['total'];
            }
            break;
        case "list":
            break;
        case "scan":
            $code = $_POST['code'];
            $proc = $_POST['process'];
            $date = $_POST['date'];
            $time = $_POST['time'];
            $date_time = $date." - ".$time;
            if($proc=="Time In")
            {
                $stmt=$dbh->prepare("Select b.customerID from tblpayment a INNER JOIN tbltransaction b ON b.trxnID=a.trxnID WHERE a.QRCode=:code");
                $stmt->bindParam(':code',$code);
                $stmt->execute();
                $count = $stmt->rowCount();
                $row   = $stmt->fetch(PDO::FETCH_ASSOC);
                if($count == 1 && !empty($row))
                {
                    //insert into tbltimecheck
                    $sql = "insert into tbltimecheck(customerID,time,timetype)values(:customer,:time,:type)";
                    $stmt=$dbh->prepare($sql);
                    $stmt->bindParam(':customer',$row['customerID']);
                    $stmt->bindParam(':time',$date_time);
                    $stmt->bindParam(':type',$proc);
                    $stmt->execute();
                    
                    $stmt = $dbh->prepare("Select a.Fullname,b.time,c.File from tblcustomer a LEFT JOIN tbltimecheck b ON b.customerID=a.customerID LEFT JOIN tblprofile c ON c.customerID=a.customerID WHERE a.customerID=:user AND b.timetype='Time In' ORDER BY b.timeID DESC LIMIT 1");
                    $stmt->bindParam(':user',$row['customerID']);
                    $stmt->execute();
                    $datas = $stmt->fetchAll();
                    foreach($datas as $list)
                    {
                        $imgUrl = "../resources/pictures/".$list['File'];
                        ?>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <center><img src="<?php echo $imgUrl; ?>" height="100" width="100"/></center>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Customer's Name</label>
                                <input type="text" class="form-control" value="<?php echo $list['Fullname'] ?>"/>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Time Check</label>
                                <input type="text" class="form-control" value="<?php echo $list['time'] ?>"/>
                            </div>
                            <div class="col-md-12 form-group">
                                <button type="button" class="btn btn-outline-success">
                                    <center><i class="icofont icofont-check-circled"></i> Time-In </center>
                                </button>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            else if($proc=="Time Out")
            {
                $stmt=$dbh->prepare("Select b.customerID from tblpayment a INNER JOIN tbltransaction b ON b.trxnID=a.trxnID WHERE a.QRCode=:code");
                $stmt->bindParam(':code',$code);
                $stmt->execute();
                $count = $stmt->rowCount();
                $row   = $stmt->fetch(PDO::FETCH_ASSOC);
                if($count == 1 && !empty($row))
                {
                    //insert into tbltimecheck
                    $sql = "insert into tbltimecheck(customerID,time,timetype)values(:customer,:time,:type)";
                    $stmt=$dbh->prepare($sql);
                    $stmt->bindParam(':customer',$row['customerID']);
                    $stmt->bindParam(':time',$date_time);
                    $stmt->bindParam(':type',$proc);
                    $stmt->execute();
                    
                    $stmt = $dbh->prepare("Select a.Fullname,b.time,c.File from tblcustomer a LEFT JOIN tbltimecheck b ON b.customerID=a.customerID LEFT JOIN tblprofile c ON c.customerID=a.customerID WHERE a.customerID=:user AND b.timetype='Time Out' ORDER BY b.timeID DESC LIMIT 1");
                    $stmt->bindParam(':user',$row['customerID']);
                    $stmt->execute();
                    $datas = $stmt->fetchAll();
                    foreach($datas as $list)
                    {
                        $imgUrl = "../resources/pictures/".$list['File'];
                        ?>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <center><img src="<?php echo $imgUrl; ?>" height="100" width="100"/></center>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Customer's Name</label>
                                <input type="text" class="form-control" value="<?php echo $list['Fullname'] ?>"/>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Time Check</label>
                                <input type="text" class="form-control" value="<?php echo $list['time'] ?>"/>
                            </div>
                            <div class="col-md-12 form-group">
                                <button type="button" class="btn btn-outline-danger">
                                    <center><i class="icofont icofont-check-circled"></i> Time-Out </center>
                                </button>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            else if($proc=="Others")
            {
                $sql = "Select a.QRCode,c.Fullname,c.EmailAddress,d.RoomNumber,b.Remarks,e.File,IFNULL(f.Change_Amount,0) as balance from tblpayment a LEFT JOIN tbltransaction b ON b.trxnID=a.trxnID LEFT JOIN tblcustomer c ON c.customerID=b.customerID LEFT JOIN tblavailableroom d ON d.aID=b.aID LEFT JOIN tblprofile e ON e.customerID=c.customerID LEFT JOIN (Select QRCode,Change_Amount from tbl_bill ORDER BY billID DESC LIMIT 1)f ON f.QRCode=a.QRCode WHERE a.QRCode=:code";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':code',$code);
                $stmt->execute();
                $count = $stmt->rowCount();
                $row   = $stmt->fetch(PDO::FETCH_ASSOC);
                if($count == 1 && !empty($row))
                {
                    $imgUrl = "../resources/pictures/".$row['File'];
                    ?>
                    <form method="get" class="row">
                        <div class="col-md-12 form-group">
                            <center><img src="<?php echo $imgUrl; ?>" height="100" width="100"/></center>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>QR Code</label>
                            <input type="text" class="form-control" value="<?php echo $row['QRCode'] ?>"/>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Customer's Name</label>
                            <input type="text" class="form-control" value="<?php echo $row['Fullname'] ?>"/>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>Email Address</label>
                                    <input type="text" class="form-control" value="<?php echo $row['EmailAddress'] ?>"/>
                                </div>
                                <div class="col-md-4">
                                    <label>Room No</label>
                                    <input type="text" class="form-control" value="<?php echo $row['RoomNumber'] ?>"/>
                                </div>
                            </div>
                        </div>
                        <?php
                        if($row['Remarks']=="Paid")
                        {
                            ?>
                            <div class="col-md-12 form-group">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Status</label>
                                        <button type="button" class="btn btn-outline-success form-control">
                                            <center><i class="icofont icofont-check-circled"></i> Check-In </center>
                                        </button>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Account Balance</label>
                                        <input type="text" class="form-control" value="<?php echo $row['balance'] ?>"/>
                                    </div>
                                </div>
                            </div>
                            <?php if($row['balance']==0)
                            {
                                
                            }
                            else
                            {
                            ?>
                                <div class="col-md-12 form-group">
                                    <a href="pay.php?QRCode=<?php echo $row['QRCode'] ?>" class="btn btn-outline-primary">Pay Now?</a>
                                </div>
                            <?php
                            }
                        }
                        else
                        {
                            ?>
                            <div class="col-md-12 form-group">
                                <button type="button" class="btn btn-outline-danger">
                                    <center><i class="icofont icofont-warning-alt"></i> <?php echo $row['Remarks'] ?></center>
                                </button>
                            </div>
                            <?php
                        }
                        ?>
                    </form>
                    <?php
                }
                else
                {
                    ?>
                    <button type="button" class="btn btn-outline-danger">
                        <center><i class="icofont icofont-warning-alt"></i> No Records Found </center>
                    </button>
                    <?php
                }
            }
            break;
        case "new":
            $aID = $_POST['aID'];
            $name = $_POST['fullname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $gender = $_POST['gender'];
            $fdate  = $_POST['fromdate'];
            $tdate = $_POST['todate'];
            $month = $_POST['month'];
            $bed = $_POST['bed_number'];
            $remarks = "UnPaid";
            $stat = 1;
            $pass= "Default";
            $type = "Walk-In";
            $code = "Default";
            $total=0.00;
            $rate = 0.00;
            $stmt=$dbh->prepare("Select NumberOfBed from tblavailableroom where aID=:id");
            $stmt->bindParam(':id',$aID);
            $stmt->execute();
            $check = $stmt->fetchAll();
            foreach($check as $number_of_bed)
            {
                if($number_of_bed['NumberOfBed']< $bed )
                {
                    echo "Invalid";
                }
                else
                {
                    $sql = "Select b.Rate from tblavailableroom a LEFT JOIN tblrooms b ON b.roomID=a.roomID WHERE a.aID=:id GROUP BY a.aID";
                    $stmt=$dbh->prepare($sql);
                    $stmt->bindParam(':id',$aID);
                    $stmt->execute();
                    $count = $stmt->rowCount();
                    $row   = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($count == 1 && !empty($row))
                    {
                        $rate = $row['Rate'];
                        $total = $rate * $month;
                    }
                    $stmt=$dbh->prepare("insert into tblcustomer(EmailAddress,Password,Fullname,Contact,Gender,Customer_type,Status,verification)
                    values(:email,SHA1(:pass),:name,:phone,:gender,:type,:stat,:code)");
                    $stmt->bindParam(':email',$email);
                    $stmt->bindParam(':pass',$pass);
                    $stmt->bindParam(':name',$name);
                    $stmt->bindParam(':phone',$phone);
                    $stmt->bindParam(':gender',$gender);
                    $stmt->bindParam(':type',$type);
                    $stmt->bindParam(':stat',$stat);
                    $stmt->bindParam(':code',$code);
                    $stmt->execute();
                    
                    $customer=0;
                    $stmt=$dbh->prepare("select customerID from tblcustomer WHERE EmailAddress=:email");
                    $stmt->bindParam(':email',$email);
                    $stmt->execute();
                    $counts = $stmt->rowCount();
                    $rows   = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($counts == 1 && !empty($rows))
                    {
                        $customer = $rows['customerID'];
                        //insert into tbltransaction
                        $stmt = $dbh->prepare("insert into tbltransaction(customerID,aID,Bed,FromDate,ToDate,TotalRate,Remarks)
                        values(:id,:room,:bed,:fdate,:tdate,:total,:remarks)");
                        $stmt->bindParam(':id',$rows['customerID']);
                        $stmt->bindParam(':room',$aID);
                        $stmt->bindParam(':bed',$bed);
                        $stmt->bindParam(':fdate',$fdate);
                        $stmt->bindParam(':tdate',$tdate);
                        $stmt->bindParam(':total',$total);
                        $stmt->bindParam(':remarks',$remarks);
                        $stmt->execute();
                    }
                    $stmt=$dbh->prepare("Select NumberOfBed from tblavailableroom where aID=:id");
                    $stmt->bindParam(':id',$aID);
                    $stmt->execute();
                    $data = $stmt->fetchAll();
                    foreach($data as $list)
                    {
                        $total = $list['NumberOfBed']-$bed;
                        $stmt=$dbh->prepare("update tblavailableroom SET NumberOfBed=:bed WHERE aID=:id");
                        $stmt->bindParam(':bed',$total);
                        $stmt->bindParam(':id',$aID);
                        $stmt->execute();
                    }
                    
                    $stmt = $dbh->prepare("Select trxnID from tbltransaction WHERE customerID=:customer AND aID=:id");
                    $stmt->bindParam(':customer',$customer);
                    $stmt->bindParam(':id',$aID);
                    $stmt->execute();
                    $bilang = $stmt->rowCount();
                    $line   = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($bilang == 1 && !empty($line))
                    {
                        echo $line['trxnID'];
                    }
                }
            }
            break;
        case "files":
            $sql = "Select * from tblfiles";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                $imgUrl = "../resources/files/".$row['File'];
                ?>
                <tr>
                    <td><?php echo $row['Date'] ?></td>
                    <td><?php echo $row['Filename'] ?></td>
                    <td><?php echo $row['Features'] ?></td>
                    <td><img src="<?php echo $imgUrl ?>" class="img-thumbnail" width="50" height="50" /></td>
                </tr>
                <?php
            }
            break;
        case "upload":
            $cat = $_POST['category'];
            $fname = $_POST['filename'];
            $feat = $_POST['features'];
            $date = date('Y-m-d');
            //files
            $name=$_FILES['file']['name'];
            $size=$_FILES['file']['size'];
            $type=$_FILES['file']['type'];
            $temp=$_FILES['file']['tmp_name'];
            $filename = date("YmdHis").'_'.$name;
            
            $move =  move_uploaded_file($temp,"files/".$filename);
                //insert into table tblwork_task
            $sql = "insert into tblfiles(Date,catID,Filename,Features,File)values(:date,:cat,:fname,:feat,:file)";
            $stmt=$dbh->prepare($sql);
            $stmt->bindParam(':date',$date);
            $stmt->bindParam(':cat',$cat);
            $stmt->bindParam(':fname',$fname);
            $stmt->bindParam(':feat',$feat);
            $stmt->bindParam(':file',$filename);
            $stmt->execute();
            echo "success";
            break;
        case "view":
            $val = $_POST['value'];
            $sql = "Select a.*,b.*,FORMAT(d.Rate,2)Rate,CONCAT(d.Name,' - ',d.Description)details from tbltransaction a LEFT JOIN tblcustomer b ON b.customerID=a.customerID LEFT JOIN tblavailableroom c ON c.aID=a.aID LEFT JOIN tblrooms d ON d.roomID=c.roomID
            WHERE a.trxnID=:id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id',$val);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                $name  = "terms-and-conditions.pdf";
                ?>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <h6>Landlord Information</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Name</label>
                                <input type="text" class="form-control" value="Mr/Mrs. Landlord"/>
                            </div>
                            <div class="col-md-12">
                                <label>Address</label>
                                <input type="text" class="form-control" value="Sample Address of the Landlord"/>
                            </div>
                            <div class="col-md-12">
                                <label>Contact No.</label>
                                <input type="phone" class="form-control" value="### #### ####"/>
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-6 form-group">
                        <h6>Tenant Information</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Name</label>
                                <input type="text" class="form-control" value="<?php echo $row['Fullname'] ?>"/>
                            </div>
                            <div class="col-md-12">
                                <label>Email Address</label>
                                <input type="email" class="form-control" value="<?php echo $row['EmailAddress'] ?>"/>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Contact No.</label>
                                        <input type="phone" class="form-control" value="<?php echo $row['Contact'] ?>"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Gender</label>
                                        <input type="text" class="form-control" value="<?php echo $row['Gender'] ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h6>Rental Information</h6>
                <div class="form-group">
                    <label>Room Type</label>
                    <textarea class="form-control" style="height:50px;"><?php echo $row['details'] ?></textarea>
                </div>
                <h6>Agreement Date</h6>
                <div class="row">
                    <div class="col-md-4">
                        <label>Start Date</label>
                        <input type="date" class="form-control" value="<?php echo $row['FromDate'] ?>"/>
                    </div>
                    <div class="col-md-4">
                        <label>End Date</label>
                        <input type="date" class="form-control" value="<?php echo $row['ToDate'] ?>"/>
                    </div>
                    <div class="col-md-4">
                        <label>Rent Amount per Month</label>
                        <input type="text" class="form-control" value="<?php echo $row['Rate'] ?>"/>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <a href="../resources/download.php?filename=<?php echo $name;?>&f=<?php echo "terms-and-conditions.pdf" ?>" class="btn btn-primary">Terms and Conditions</a>
                </div>
                <?php
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