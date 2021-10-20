<?php

include "config.php";

$request = 2;


// Read $_GET value
if (isset($_GET['request'])) {
    $request = $_GET['request'];
}

// Fetch records 
if ($request == 1) {
    $type = $_GET['type'];
    if ($type == "donor") {
        $zip_code = $_GET['zipCode'];


        // Select record 
        $sql = "SELECT Center_ID, Center_Name, Center_Address from center where zip_code='" . $zip_code . "' LIMIT 1";

        $donorData = mysqli_query($con, $sql);

        $response = array();
        while ($row = mysqli_fetch_assoc($donorData)) {
            $response[] = array(
                "Center_ID" => $row['Center_ID'],
                "Center_Name" => $row['Center_Name'],
                "Center_Address" => $row['Center_Address'],
            );
        }



        echo json_encode($response);
    } else if ($_GET['type'] == "receiver") {
        $zip_code = $_GET['zipCode'];
        $blood_group = $_GET['blood_group'];
        $blood_type = $_GET['blood_type'];

        // Select record 
        $sql = "SELECT Center_ID, Center_Name, Center_Address from center where "
                . "zip_code='" . $zip_code . "' and Blood_Type='" . $blood_type . "' "
                . "and Blood_ID=(select Blood_ID from blood where Blood_Group='" . $blood_group . "')";

        $donorData = mysqli_query($con, $sql);

        $response = array();
        while ($row = mysqli_fetch_assoc($donorData)) {
            $response[] = array(
                "Center_ID" => $row['Center_ID'],
                "Center_Name" => $row['Center_Name'],
                "Center_Address" => $row['Center_Address'],);
        }

        echo json_encode($response);
    }
    
    else if ($_GET['type'] == "center") {
        
        // Select record 
        $sql = "SELECT Center_ID, Center_Name, Center_Address, Zip_Code, Blood_Group, Blood_Type, Quantity from center c join blood b on (c.Blood_ID=b.Blood_ID)";
        
        $centerData = mysqli_query($con, $sql);

        $response = array();
        while ($row = mysqli_fetch_assoc($centerData)) {
            $response[] = array(
                "Center_ID" => $row['Center_ID'],
                "Center_Name" => $row['Center_Name'],
                "Center_Address" => $row['Center_Address'],
                "Zip_Code" => $row['Zip_Code'],
                "Blood_Group" => $row['Blood_Group'],
                "Blood_Type" => $row['Blood_Type'],
                "Quantity" => $row['Quantity'],);
        }

        echo json_encode($response);
    }
}

// Insert record
if ($request == 2) {
    // Read POST data
    $data = json_decode(file_get_contents("php://input"));
    $type = $data->type;
    if ($type == "donor") {

        $zip_code = $data->zip_code;
        $center_id = $data->center_id;
        $center_name = $data->center_name;
        $center_address = $data->center_address;
        $donor_name = $data->donor_name;
        $donor_address = $data->donor_address;
        $donor_blood_group = $data->donor_blood_group;
        $donation_type = $data->donation_type;
        $quantity = $data->quantity;
        $date = $data->date;
        $blood_id = "";
        $qry = 'SELECT blood_id from blood where Blood_Group ="' . trim(strtoupper($donor_blood_group)) . '" LIMIT 1';

        $results = mysqli_query($con, $qry);

        while ($row = mysqli_fetch_assoc($results)) {
            $blood_id = $row['blood_id'];
        }

        // Insert record
        $sql = "insert into donor(Donor_Name,Donor_Address,Zip_Code,Blood_Group,Donation_Type,Quantity,Date,Center_ID) values('" . $donor_name . "','" . $donor_address . "','" . $zip_code . "','" . $donor_blood_group . "','" . $donation_type . "','" . $quantity . "','" . $date . "','" . $center_id . "')";

        if (mysqli_query($con, $sql)) {
            $sql = "insert into center (Center_ID,Center_Name,Center_Address,Zip_Code,Blood_ID,Blood_Type,Quantity) "
                    . "values("
                    . "'" . $center_id . "',"
                    . "'" . $center_name . "',"
                    . "'" . $center_address . "',"
                    . "'" . $zip_code . "',"
                    . "'" . $blood_id . "',"
                    . "'" . $donation_type . "',"
                    . "'" . $quantity . "'"
                    . ") ON DUPLICATE KEY UPDATE
                                    Quantity = quantity+VALUES(quantity)";

            if (mysqli_query($con, $sql)) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }



        exit;
    } else if ($type == "receiver") {
        $zip_code = $data->zip_code;
        $blood_group = $data->blood_group;
        $b_type = $data->b_type;
        $center_id = $data->center_id;
        $center_name = $data->center_name;
        $center_address = $data->center_address;
        $receiver_name = $data->receiver_name;
        $receiver_address = $data->receiver_address;
        $quantity = $data->quantity;
        $date = $data->date;
        $blood_id = "";

        $getBloodID = 'select blood_id from blood where blood_group="' . $blood_group . '"';

        $results = mysqli_query($con, $getBloodID);

        while ($row = mysqli_fetch_assoc($results)) {
            $blood_id = $row['blood_id'];
        }

        $qry = 'select quantity from center where zip_code="' . $zip_code . '" and blood_type="' . $b_type . '" and blood_id="' . $blood_id . '"';

        $results = mysqli_query($con, $qry);

        while ($row = mysqli_fetch_assoc($results)) {
            $quantityNew = $row['quantity'];
        }



        if ($quantity > $quantityNew) {
            echo 3;
        } else {
            $sql = "insert into recipient(Receiver_Name,Receiver_Address,Zip_Code,Blood_Group,Type,Quantity,Date,Center_ID) "
                    . "values('" . $receiver_name . "','" . $receiver_address . "','" . $zip_code . "','" . $blood_group . "','" . $b_type . "','" . $quantity . "','" . $date . "','" . $center_id . "')";




            if (mysqli_query($con, $sql)) {
                $sql = "update center set quantity = quantity - '" . $quantity . "' where center_id= '" . $center_id . "' and blood_id= (select blood_id from blood where blood_group= '" . $blood_group . "') and blood_type='" . $b_type . "'";

                if (mysqli_query($con, $sql)) {
                    echo 1;
                } else {
                    echo 0;
                }
            } else {
                echo 0;
            }



            exit;
        }
    }
}
    