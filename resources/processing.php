<?php
require_once("dbconfig.php");
try
{
    $action = $_POST['action'];
    switch($action)
    {
        case "accounts":
            $sql = "Select * from tblaccount ORDER BY EmployeeID";
            $stmt=$dbh->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                if($row['Status']==1)
                {
                    ?>
                    <tr>
                        <td><?php echo $row['EmployeeID'] ?></td>
                        <td><?php echo $row['Fullname'] ?></td>
                        <td><?php echo $row['Designation'] ?></td>
                        <td><?php echo $row['EmailAddress'] ?></td>
                        <td><span class='badge bg-primary'> Active</span></td>
                        <td><button type='button' class='btn btn-outline-primary btn-sm update' value="<?php echo $row['EmployeeID'] ?>">Update</button></td>
                    </tr>
                    <?php
                }
                else
                {
                    ?>
                    <tr>
                        <td><?php echo $row['EmployeeID'] ?></td>
                        <td><?php echo $row['Fullname'] ?></td>
                        <td><?php echo $row['Designation'] ?></td>
                        <td><?php echo $row['EmailAddress'] ?></td>
                        <td><span class='badge bg-danger'> Inactive</span></td>
                        <td><button type='button' class='btn btn-outline-primary btn-sm update' value="<?php echo $row['EmployeeID'] ?>">Update</button></td>
                    </tr>
                    <?php
                }
            }
            break;
        case "search-accounts":
            $text = "%".$_POST['keyword']."%";
            $sql = "Select * from tblaccount WHERE Fullname LIKE :text ORDER BY EmployeeID";
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
                        <td><?php echo $row['EmployeeID'] ?></td>
                        <td><?php echo $row['Fullname'] ?></td>
                        <td><?php echo $row['Designation'] ?></td>
                        <td><?php echo $row['EmailAddress'] ?></td>
                        <td><span class='badge bg-primary'> Active</span></td>
                        <td><button type='button' class='btn btn-outline-primary btn-sm update' value="<?php echo $row['EmployeeID'] ?>">Update</button></td>
                    </tr>
                    <?php
                }
                else
                {
                    ?>
                    <tr>
                        <td><?php echo $row['EmployeeID'] ?></td>
                        <td><?php echo $row['Fullname'] ?></td>
                        <td><?php echo $row['Designation'] ?></td>
                        <td><?php echo $row['EmailAddress'] ?></td>
                        <td><span class='badge bg-danger'> Inactive</span></td>
                        <td><button type='button' class='btn btn-outline-primary btn-sm update' value="<?php echo $row['EmployeeID'] ?>">Update</button></td>
                    </tr>
                    <?php
                }
            }
            break;
        case "register":
            $name = $_POST['fullname'];
            $job = $_POST['designation'];
            $id = $_POST['employeeID'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $stat = 1;
            $password = "Qwerty1234";
            if(empty($name)||empty($job)||empty($id)||empty($email)||empty($role))
            {
                echo "Please fill in the form";
            }
            else
            {
                $sql = "insert into tblaccount(EmailAddress,Password,Fullname,Designation,EmployeeID,Role,Status)
                values(:email,SHA1(:pass),:name,:job,:id,:role,:stat)";
                $savestmt = $dbh->prepare($sql);
                $savestmt->bindParam(':email',$email);
                $savestmt->bindParam(':pass',$password);
                $savestmt->bindParam(':name',$name);
                $savestmt->bindParam(':job',$job);
                $savestmt->bindParam(':id',$id);
                $savestmt->bindParam(':role',$role);
                $savestmt->bindParam(':stat',$stat);
                $savestmt->execute();
                echo "success";
            }
            break;
        case "update-employee":
            $id = $_POST['employee'];
            $stat = $_POST['status'];
            if(empty($stat))
            {
                echo "Please choose employee status";
            }
            else
            {
                $sql = "update tblaccount SET Status=:stat WHERE EmployeeID=:id";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':stat',$stat);
                $stmt->bindParam(':id',$id);
                $stmt->execute();
                echo "Successfully updated";
            }
            break;
        case "rooms":
            $sql = "Select b.*,a.Description as Category,FORMAT(b.Rate,2)Rates from tblrooms b LEFT JOIN tblcategory a ON b.catID=a.catID GROUP BY b.roomID,a.catID ORDER BY b.roomID";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                ?>
                <tr>
                    <td><?php echo $row['Category'] ?></td>
                    <td><?php echo $row['Name'] ?></td>
                    <td><?php echo $row['Description'] ?></td>
                    <td style='text-align:right;'>PHP <?php echo $row['Rates'] ?></td>
                    <td><button type='button' class="btn btn-outline-primary btn-sm change" value="<?php echo $row['roomID'] ?>"> Update</button></td>
                </tr>
                <?php
            }
            break;
        case "search-rooms":
            $text = "%".$_POST['keyword']."%";
            $sql = "Select b.*,a.Description as Category,FORMAT(b.Rate,2)Rates from tblrooms b LEFT JOIN tblcategory a ON b.catID=a.catID WHERE b.Name LIKE :text GROUP BY b.roomID,a.catID ORDER BY b.roomID";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':text',$text);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                ?>
                <tr>
                    <td><?php echo $row['Category'] ?></td>
                    <td><?php echo $row['Name'] ?></td>
                    <td><?php echo $row['Description'] ?></td>
                    <td style='text-align:right;'>PHP <?php echo $row['Rates'] ?></td>
                    <td><button type='button' class="btn btn-outline-primary btn-sm change" value="<?php echo $row['roomID'] ?>"> Update</button></td>
                </tr>
                <?php
            }
            break;
        case "new-category":
            $cat = $_POST['category'];
            if(empty($cat))
            {
                echo "Please enter new category";
            }
            else
            {
                $sql = "insert into tblcategory(Description)values(:cat)";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':cat',$cat);
                $stmt->execute();
                echo "success";
            }
            break;
        case "category":
            $sql = "Select catID,Description from tblcategory";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                ?>
                <option value="<?php echo $row['catID'] ?>"><?php echo $row['Description'] ?></option>
                <?php
            }
            break;
        case "number":
            $sql = "Select roomID,Name from tblrooms";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                ?>
                <option value="<?php echo $row['roomID'] ?>"><?php echo $row['Name'] ?></option>
                <?php
            }
            break;
        case "new-room":
            $cat = $_POST['category'];
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $rate = $_POST['rate'];
            if(empty($cat)||empty($name)||empty($desc)||empty($rate))
            {
                echo "Please fill in the form";
            }
            else
            {
                $sql = "insert into tblrooms(catID,Name,Description,Rate)values(:cat,:name,:desc,:rate)";
                $stmt=$dbh->prepare($sql);
                $stmt->bindParam(':cat',$cat);
                $stmt->bindParam(':name',$name);
                $stmt->bindParam(':desc',$desc);
                $stmt->bindParam(':rate',$rate);
                $stmt->execute();
                echo "success";
            }
            break;
        case "new":
            $sql = "Select a.*,b.*,FORMAT(b.Rate,2)Rate,c.Description as Category,a.NumberOfBed from tblavailableroom a LEFT JOIN tblrooms b ON b.roomID=a.roomID LEFT JOIN tblcategory c ON c.catID=b.catID GROUP BY a.aID";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row)
            {
                if($row['Status']==1)
                {
                ?>
                    <tr>
                        <td><?php echo $row['Category'] ?></td>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['NumberOfBed'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td><span class='badge bg-primary'> Operational</span></td>
                        <td><button type="button" class="btn btn-outline-primary btn-sm update" value="<?php echo $row['aID'] ?>">Update</button></td>
                    </tr>
                    <?php
                }
                else
                {
                    ?>
                    <tr>
                        <td><?php echo $row['Category'] ?></td>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['NumberOfBed'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td><span class='badge bg-danger'> Under-maintenance</span></td>
                        <td><button type="button" class="btn btn-outline-primary btn-sm update" value="<?php echo $row['aID'] ?>">Update</button></td>
                    </tr>
                    <?php
                }
            }
            break;
        case "search-room-number":
            $text = "%".$_POST['keyword']."%";
            $sql = "Select a.*,b.*,FORMAT(b.Rate,2)Rate,c.Description as Category,a.NumberOfBed from tblavailableroom a LEFT JOIN tblrooms b ON b.roomID=a.roomID LEFT JOIN tblcategory c ON c.catID=b.catID 
            WHERE a.RoomNumber LIKE :text GROUP BY a.aID";
            $stmt = $dbh->prepare($sql);
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
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['NumberOfBed'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td><span class='badge bg-primary'> Operational</span></td>
                        <td><button type="button" class="btn btn-outline-primary btn-sm update" value="<?php echo $row['aID'] ?>">Update</button></td>
                    </tr>
                    <?php
                }
                else
                {
                    ?>
                    <tr>
                        <td><?php echo $row['Category'] ?></td>
                        <td><?php echo $row['RoomNumber'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['NumberOfBed'] ?></td>
                        <td style="text-align:right;">PHP <?php echo $row['Rate'] ?></td>
                        <td><span class='badge bg-danger'> Under-maintenance</span></td>
                        <td><button type="button" class="btn btn-outline-primary btn-sm update" value="<?php echo $row['aID'] ?>">Update</button></td>
                    </tr>
                    <?php
                }
            }
            break;
        case "add-room":
                $room = $_POST['room-type'];
                $number = $_POST['room_number'];
                $status = $_POST['status'];
                $bed = $_POST['bed_number'];
                $remarks = "Available";
                if(empty($room)||empty($number)||empty($status))
                {
                    echo "Please fill in the form";
                }
                else
                {
                    $sql = "insert into tblavailableroom(roomID,RoomNumber,NumberOfBed,Status,Remarks)values(:id,:number,:bed,:status,:remarks)";
                    $stmt=$dbh->prepare($sql);
                    $stmt->bindParam(':id',$room);
                    $stmt->bindParam(':number',$number);
                    $stmt->bindParam(':bed',$bed);
                    $stmt->bindParam(':status',$status);
                    $stmt->bindParam(':remarks',$remarks);
                    $stmt->execute();
                    echo "success";
                }
            break;
        case "new-rate":
            $amount = $_POST['rate'];
            $id = $_POST['id'];
            if(empty($amount))
            {
                echo "Please enter new rate";
            }
            else
            {
                $sql = "update tblrooms SET Rate=:rate WHERE roomID=:id";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':rate',$amount);
                $stmt->bindParam(':id',$id);
                $stmt->execute();
                echo "Successfully updated";
            }
            break;
        case "update":
            $room = $_POST['room'];
            $stat = $_POST['status'];
            if(empty($stat))
            {
                echo "Please choose status";
            }
            else
            {
                $sql = "update tblavailableroom SET Status=:stat WHERE aID=:id";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':stat',$stat);
                $stmt->bindParam(':id',$room);
                $stmt->execute();
                echo "Successfully updated";
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