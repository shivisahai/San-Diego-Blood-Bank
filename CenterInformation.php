<html>
    <head>
        <title>
            Center Information
        </title>
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
        <div id="div1" style="background-image: url('img2.jpg'); background-size: cover; height: 660px">
            <table id="table1">
                <tbody>	
                    <tr>
                        <td>
                            <img id="img1" src="SDBB_logo.png" class="img1">
                        </td>
                        <td>
                            <label id="label1" class="label1"><b>SAN DIEGO BLOOD BANK</b></label>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size:14px">
                            <a href="index.php">Back to Home Page</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div id="div2" style="font-size: 24px; max-height: 470px; overflow-y: scroll"><b><p><u>Center Information</u></p></b>
                <table id="table2" bordercolor="blue" style="border-width: 2px; max-height: 470px; overflow-y: scroll; background-color: thistle; border-width: 2px">
                    <thead>
                        <tr class="tabDesign2">
                            <th>Center ID</th>
                            <th>Center Name</th>
                            <th>Center Address</th>
                            <th>Zip Code</th>
                            <th>Blood Group</th>
                            <th>Blood Type</th>
                            <th>Blood Quantity</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
</html>
<script>
    function loadCenterData() {
        var xhttp = new XMLHttpRequest();
        // Set GET method and ajax file path with parameter
        xhttp.open("GET", "ajaxfile.php?request=1&&type=center", true);

        // Content-type
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        console.log('hi');
        // call on request changes state
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                // Parse this.responseText to JSON object
                var response = JSON.parse(this.responseText);

                if (response && response.length) {
                    var table2 = document.getElementById("table2").getElementsByTagName("tbody")[0];

                    // Empty the table <tbody>
                    table2.innerHTML = "";

                    // Loop on response object
                    for (var key in response) {
                        if (response.hasOwnProperty(key)) {
                            var val = response[key];

                            // insert new row
                            var NewRow = table2.insertRow(0);
                            var center_id = NewRow.insertCell(0);
                            var center_name = NewRow.insertCell(1);
                            var center_address = NewRow.insertCell(2);
                            var zip_code = NewRow.insertCell(3);
                            var blood_group = NewRow.insertCell(4);
                            var blood_type = NewRow.insertCell(5);
                            var blood_quantity = NewRow.insertCell(6);

                            center_id.innerHTML = val['Center_ID'];
                            center_name.innerHTML = val['Center_Name'];
                            center_address.innerHTML = val['Center_Address'];
                            zip_code.innerHTML = val['Zip_Code'];
                            blood_group.innerHTML = val['Blood_Group'];
                            blood_type.innerHTML = val['Blood_Type'];
                            blood_quantity.innerHTML = val['Quantity'];

                            center_id.classList.add('tableDesign1');
                        }
                    }
                }
            }
        };
        // Send request
        console.log('bye');
        xhttp.send();
    }
    loadCenterData();
</script>
