<?php
include("dbconfig.php");
try
{
    switch($_POST['action'])
    {
        case "customer":
            $sql = "Select * from tblcustomer ORDER BY customerID DESC";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                if($row['Status']==0)
                {
                    ?>
                    <tr>
                        <td><?php echo $row['Fullname'] ?></td>
                        <td><?php echo $row['EmailAddress'] ?></td>
                        <td><?php echo $row['Contact'] ?></td>
                        <td><?php echo $row['Gender'] ?></td>
                        <td><span class="badge bg-warning"> Pending </span></td>
                    </tr>
                    <?php
                }
                else
                {
                    ?>
                    <tr>
                        <td><?php echo $row['Fullname'] ?></td>
                        <td><?php echo $row['EmailAddress'] ?></td>
                        <td><?php echo $row['Contact'] ?></td>
                        <td><?php echo $row['Gender'] ?></td>
                        <td><span class="badge bg-success"> Verified </span></td>
                    </tr>
                    <?php
                }
            }
            break;
        case "feedback":
            $sql = "Select a.feedID,a.Subject,b.Fullname from tblfeedback a LEFT JOIN tblcustomer b ON b.customerID=a.customerID GROUP BY a.feedID";
            $stmt=$dbh->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                ?>
                <tr>
                    <td><button type="button" class="btn btn-outline-primary btn-sm view" value="<?php echo $row['feedID'] ?>">View</button></td>
                    <td><?php echo $row['Fullname'] ?></td>
                    <td><?php echo $row['Subject'] ?></td>
                </tr>
                <?php
            }
            break;
        case "view":
            $id = $_POST['value'];
            $sql = "Select * from tblfeedback WHERE feedID=:id";
            $stmt=$dbh->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                $file = $row['File'];
                ?>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Date</label>
                        <input type="date" class="form-control" value="<?php echo $row['Date'] ?>"/>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Subject</label>
                        <input type="text" class="form-control" value="<?php echo $row['Subject'] ?>"/>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Details</label>
                        <textarea class="form-control" style="height:100px;overflow-y:auto;"><?php echo $row['Details'] ?></textarea>
                    </div>
                    <div class="col-md-12 form-group">
                        <a href="../resources/attachment.php?filename=<?php echo $file?>&f=<?php echo $row['File'] ?>" class="btn btn-link"><?php echo $file ?></a>
                    </div>
                </div>
                <?php
            }
            break;
        case "send":
            $customer = $_POST['customer'];
            $date = date('Y-m-d');
            $subj = $_POST['subject'];
            $details = $_POST['details'];
            if(empty($subj)||empty($details))
            {
                echo "Please fill in the form";
            }
            else
            {
                $name=$_FILES['file']['name'];
                $size=$_FILES['file']['size'];
                $type=$_FILES['file']['type'];
                $temp=$_FILES['file']['tmp_name'];
                $filename = date("YmdHis").'_'.$name;
                
                $move =  move_uploaded_file($temp,"feedback/".$filename);
                
                $sql = "insert into tblfeedback(customerID,Subject,Details,File,Date)values(:customer,:subj,:details,:file,:date)";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':customer',$customer);
                $stmt->bindParam(':subj',$subj);
                $stmt->bindParam(':details',$details);
                $stmt->bindParam(':file',$filename);
                $stmt->bindParam(':date',$date);
                $stmt->execute();
                echo "success";
            }
            break;
        case "mylogs":
            $user = $_POST['user'];
            $sql = "Select feedID,Subject,Details from tblfeedback WHERE customerID=:user";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':user',$user);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                ?>
                <tr>
                    <td><a class='btn btn-outline-primary view' href="view-message.php?id=<?php echo $row['feedID'] ?>"> View </a></td>
                    <td><?php echo $row['Subject'] ?></td>
                    <td><?php echo $row['Details'] ?></td>
                </tr>
                <?php
            }
            break;
        case "searchlogs":
            $user = $_POST['user'];
            $text = "%".$_POST['keyword']."%";
            $sql = "Select feedID,Subject,Details from tblfeedback WHERE customerID=:user AND Subject LIKE :text";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':user',$user);
            $stmt->bindParam(':text',$text);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                ?>
                <tr>
                    <td><a class='btn btn-outline-primary view' href="view-message.php?id=<?php echo $row['feedID'] ?>"> View </a></td>
                    <td><?php echo $row['Subject'] ?></td>
                    <td><?php echo $row['Details'] ?></td>
                </tr>
                <?php
            }
            break;
        case "comment":
            $id = $_POST['id'];
            $sql = "Select a.*,b.Fullname,b.Designation from tblcomment a LEFT JOIN tblaccount b ON b.adminID=a.userID WHERE a.feedID = :id GROUP BY a.commentID DESC";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                ?>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <div class="col-md-12">
                            <div><a href=""><?php echo $row['Fullname'] ?></a>  - <span><small><?php echo $row['Designation'] ?></small></span></div>
                            <textarea class="form-control" disabled><?php echo $row['Message'] ?></textarea>
                            <p><?php echo $row['Date'] ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
            break;
        case "new-comment":
            $id = $_POST['feed'];
            $user = $_POST['user'];
            $msg = $_POST['message'];
            $date = date('Y-m-d H:m:s a');
            
            $sql = "insert into tblcomment(Message,userID,feedID,Date)values(:msg,:user,:id,:date)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':msg',$msg);
            $stmt->bindParam(':user',$user);
            $stmt->bindParam(':id',$id);
            $stmt->bindParam(':date',$date);
            $stmt->execute();
            echo "Success";
            break;
        case "get":
            $id = $_POST['feed'];
            $sql = "Select a.*,b.Fullname,b.Designation from tblcomment a LEFT JOIN tblaccount b ON b.adminID=a.userID WHERE a.feedID = :id GROUP BY a.commentID DESC";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                ?>
                <div class="form-group">
                    <div><a href=""><?php echo $row['Fullname'] ?></a>  - <span><small><?php echo $row['Designation'] ?></small></span></div>
                    <textarea class="form-control" disabled><?php echo $row['Message'] ?></textarea>
                    <p><?php echo $row['Date'] ?></p>
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