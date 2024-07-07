<?php 
    

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dateStart = $_POST["eventStartDate"];
    $dateEnd = $_POST["eventEndDate"];
    $region = $_POST["country"];
    $msgType = $_POST["messageType"];
    $message = $_POST["message"];

    echo "<div class='alert alert-{$msgType}'>{$message}</div>";

    $sql = "";

    if($region == 'All')
    {
        $sql = "SELECT event_id, event_name, description, date_start, region_id, event_status FROM event where date_start >= '$dateStart' and date_start <= '$dateEnd'";
    }
    else
    {
        $sql = "SELECT event_id, event_name, description, date_start, region_id, event_status FROM event where date_start >= '$dateStart' and date_start <= '$dateEnd' and region_id = '$region'";
    }

    $result = $conn->query($sql);
    $events = array();

    $counter = 0;
    ?>
    <?php
    if ($result->num_rows > 0) {
        
        while ($row = $result->fetch_assoc()) {
            echo "<form  action='after_update.php' method='post'>";
            ?>
        <div class=" col-md-12">
            <form action="update.php" method="post">
            
            <div class="col-md-12 event-update-form">

                <div class="form-group" style="display: none;">
                    <input type="text" class="form-control"  name="eventID" id="eventID" value="<?php echo $row["event_id"];?>">
                    <input type="text" class="form-control"  name="eventStartDate" id="eventStartDate" value="<?php echo $dateStart;?>">
                    <input type="text" class="form-control"  name="eventEndDate" id="eventEndDate" value="<?php echo $dateEnd;?>">
                    <input type="text" class="form-control"  name="selectedRegion" id="selectedRegion" value="<?php echo $region;?>">    
                </div>
                <div class="form-group">
                    <?php 
                    if ($counter == 0) 
                    {
                        echo '<label for="eventName">Title</label>';
                    }
                    ?>
                    <input type="text" class="form-control"  name="eventName" id="eventName" value="<?php echo $row["event_name"];?>">    
                </div>
                <div class="form-group form-event-description">
                    <?php 
                    if ($counter == 0) 
                    {
                        echo '<label for="eventDescription">Description</label>';
                    }
                    ?>
                    
                    <textarea class="form-control" name="eventDescription" id="eventDescription" rows="1"><?php echo $row["description"];?></textarea>
                </div>
                <div class="form-group">
                    
                    <?php 
                    if ($counter == 0) 
                    {
                        echo '<label for="eventEndDate">Date</label>';
                    }
                    ?>
                    <input type="date" class="form-control" name="eventDate" id="eventDate" value="<?php echo $row["date_start"];?>"  >  
                </div>
                <?php 

                $regionID = $row['region_id'];
                
                $allOtherRegionsSQL = "SELECT region_id from region where region_id != '$regionID'";
                $allOtherRegionsSQLResult = $conn->query($allOtherRegionsSQL);

                $currentRegionSQL = "SELECT region_id from region where region_id = '$regionID'";
                $currentRegionSQLResult = $conn->query($currentRegionSQL);

                ?>
                <div class="form-group" style="width: 55px;">
                    
                    <?php 
                    if ($counter == 0) 
                    {
                        echo '<label for="country">Country</label>';
                    }
                    ?>
                    <select id="country" class="form-control" name="country" required>
                    <?php 
                        while($currentRegionSQLRow = $currentRegionSQLResult->fetch_assoc())
                        { 
                        ?>
                        <option><?php echo $currentRegionSQLRow["region_id"];?></option>
                        <?php
                        }
                    ?>
                    <?php 
                        while($allOtherRegionsSQLRow = $allOtherRegionsSQLResult->fetch_assoc())
                        { 
                        ?>
                        <option><?php echo $allOtherRegionsSQLRow["region_id"];?></option>
                        <?php
                        }
                    ?>
                    </select>
                </div>

                <?php

                $currentEventStatus = $row['event_status'];
                $theOtherEventStatus = "";
                
                if ($currentEventStatus == 'active')
                {
                    $theOtherEventStatus = 'inactive';
                }
                else
                {
                    $theOtherEventStatus = "active";
                }

                ?>
                <div class="form-group">
                    
                    <?php 
                    if ($counter == 0) 
                    {
                        echo '<label for="event-status">Status</label>';
                    }
                    ?>
                    <select id="event-status" class="form-control" name="event-status" required>
                        <option><?php echo $currentEventStatus;?></option>
                        <option><?php echo $theOtherEventStatus;?></option>
                    </select>
                </div>
                <div class="form-group event-update-button-submit">
                    <?php 
                    if ($counter == 0) 
                    {
                        echo '<label for="submit">Update</label>';
                    }
                    ?>
                    <button type="submit" class="btn btn-primary" name="submit" id="submit" value="Submit">Update</button>
                </div>
            </div>
            </form>
        </div>
        
        <?php
        $counter++;
        }
    
    }
    else
    {
        echo 'No Events Found';
    }
    echo '<br>
    <br>';
    $conn->close();

}

?>