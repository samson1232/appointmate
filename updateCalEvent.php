<?php 

    if($isAdmin || $isOrganizer || $isConvenor)
    {
?>
        <div class="container add-calendar-event col-md-6">
            <h1 class="calendar-event-title">Update a calendar event</h1>

            <form action="admin_panel.php?page=update" method="post">
                <h4 class="calendar-event-title">Filter</h4>
                <div class="col-md-12" style="display: flex; column-gap: 15px; flex-wrap: wrap;">
                    <div class="form-group">
                        <label for="eventStartDate">Start Date</label>
                        <input type="date" class="form-control"  name="eventStartDate" id="eventStartDate" placeholder="YYYY-MM-DD" required >    
                    </div>
                    <div class="form-group">

                        <label for="eventEndDate">End Date</label>
                        <input type="date" class="form-control"  name="eventEndDate" id="eventEndDate" placeholder="YYYY-MM-DD" required >  
                    </div>
                    <div class="form-group">
                        <label for="country">Country</label>
                        <select class="form-control" id="country" name="country" required>
                            <option>All</option>
                        <?php
                            $regions = $conn->query("SELECT region_id FROM region");
                            while ($row = $regions->fetch_assoc()) {
                                echo '<option>'.$row['region_id'].'</option>';
                            }
                        ?>
                        </select>
                    </div>
                    <div class="form-group" style="display: none;">
                        <label for="messageType">Message Type</label>
                        <input type="text" class="form-control"  name="messageType" id="messageType">  
                    </div>
                    <div class="form-group" style="display: none;">
                        <label for="message">Message</label>
                        <input type="text" class="form-control"  name="message" id="message">  
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" id="update-submit" value="Submit">Find</button>
            </form>
        </div>
        <script>
            window.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const startDate = urlParams.get('eventStartDate');
            const endDate = urlParams.get('eventEndDate');
            const country = urlParams.get('country');  
            const messageType = urlParams.get('messageType');
            const message = urlParams.get('message');    

            if (startDate && endDate && country) {
                document.getElementById('eventStartDate').value = startDate;
                document.getElementById('eventEndDate').value = endDate;
                document.getElementById('country').value = country;
                document.getElementById('messageType').value = messageType;
                document.getElementById('message').value = message;

                let button = document.getElementById('update-submit');
                button.click();
            }
        });
        </script>
<?php
    }
?>
