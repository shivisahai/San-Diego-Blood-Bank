<html>
    <head>
        <title>
            Welcome Receiver
        </title>
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
        <div id="div1" style="background-image: url('img2.jpg'); background-size: 1410px 700px; height: 700px">
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
            <div id="div2">
                <table id="table2">
                    <tbody>
                        <tr>
                            <th class="pageHeading"><b><p><u>Receiver Information</u></p></b></th>
                        </tr>
                        <tr>
                            <td style="padding-top: 10px">Please provide the information below to check your nearest Blood donation Center for availability:</td>
                        </tr>
                    </tbody>
                </table>
                <div id="div3" class="divBox" style="padding-bottom: 10px; width: 480px; padding-left: 150px">
                    <table>
                        <tbody>
                            <tr>
                                <td><label>Zip Code: </label></td>
                                <td><input type="text" id="textbox1"/></td>
                            </tr>
                            <tr>
                                <td><label>Blood Group: </label></td>
                                <td><input type="text" id="textbox11"/></td>
                            </tr>
                            <tr>
                                <td><label>Type: </label></td>
                                <td>
                                    <select id="receivingType">
                                        <option value="Whole Blood">Whole Blood</option>
                                        <option value="Red Blood Cells">Red Blood Cells</option>
                                        <option value="Platelet">Platelet</option>
                                        <option value="Plasma">Plasma</option>
                                    </select>
                                </td>
                            </tr>
                            <tr></tr>
                        </tbody>
                    </table>
                    <div style="padding-left: 70px; padding-top: 10px; padding-bottom: 5px">
                        <button id="btn1" onclick="checkBloodAvailability()"><b>Check Availability</b></button>
                    </div>
                </div>
                <div id="displayTable" style="display: none">
                    <div id=""div5" style="padding-top: 30px;">Please provide the information below to book appointment:</div>
                    <div id="div6" class="divBox" style="width: 480px; padding-left: 150px;">
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <label>Center ID: </label>
                                    </td>
                                    <td>
                                        <input type="text" id="textbox2" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Center Name: </label>
                                    </td>
                                    <td>
                                        <input type="text" id="textbox3" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Center Address: </label>
                                    </td>
                                    <td>
                                        <textarea id="textarea2" rows="5" cols="35" readonly></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>*Receiver Name: </label>
                                    </td>
                                    <td>
                                        <input type="text" id="textbox6" placeholder="Enter your name"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>*Receiver Address: </label>
                                    </td>
                                    <td>
                                        <textarea id="textarea1" rows="5" cols="35" placeholder="Enter your address"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>*Quantity: </label>
                                    </td>
                                    <td>
                                        <input type="text" id="textbox8" placeholder="Enter quantity (ml)"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Date: </label>
                                    </td>
                                    <td>
                                        <input type="text" id="textbox9" placeholder="<?= Date('j-n-Y') ?>" readonly/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="padding-left: 100px; padding-top: 10px; padding-bottom: 10px">
                            <button id="btn2" onclick="submitReceiverInfo()"><b>Submit</b></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    function checkBloodAvailability() {
        var xhttp = new XMLHttpRequest();

        var zip_code = document.getElementById('textbox1').value;
        var blood_group = document.getElementById('textbox11').value;
        var type = document.getElementById('receivingType').value;

        if (zip_code != "" && blood_group != "" && type != "") {
            if (blood_group === "A+" || blood_group === "a+" ||
                    blood_group === "A-" || blood_group === "a-" ||
                    blood_group === "B+" || blood_group === "b+" ||
                    blood_group === "B-" || blood_group === "b-" ||
                    blood_group === "AB+" || blood_group === "ab+" ||
                    blood_group === "AB-" || blood_group === "ab-" ||
                    blood_group === "O+" || blood_group === "o+" ||
                    blood_group === "O-" || blood_group === "o-") {

                // Set GET method and ajax file path with parameter
                xhttp.open("GET", "ajaxfile.php?request=1&&zipCode=" + zip_code + "&&blood_group=" + encodeURIComponent(blood_group) + "&&blood_type=" + type + "&&type=receiver", true);

                // Content-type
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                // call on request changes state
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {

                        // Parse this.responseText to JSON object
                        var response = JSON.parse(this.responseText);
                        console.log(response);

                        if (response && response.length) {
                            document.getElementById("textbox2").value = response[0].Center_ID;
                            document.getElementById("textbox3").value = response[0].Center_Name;
                            document.getElementById("textarea2").value = response[0].Center_Address;
                            document.getElementById("displayTable").style.removeProperty('display');
                        } else {
                            alert("Sorry! The requested blood group is not available in this zip code. Please try again.");
                        }
                    }
                };

                // Send request
                xhttp.send();
            } else {
                alert("Invalid Blood Group!!");
            }
        } else {
            alert("Please fill all the fields!");
        }
    }

    function postAjax(data) {
        var xhttp = new XMLHttpRequest();
        // Set POST method and ajax file path
        xhttp.open("POST", "ajaxfile.php", true);

        // call on request changes state
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(response);

                var response = this.responseText;
                if (response == 3) {
                    alert("Required blood quantity not available!");
                } else if (response == 1) {
                    alert("Blood Received!");
                    clear();
                    document.getElementById("displayTable").style.display = 'none';
                }
            }
        };

        // Content-type
        xhttp.setRequestHeader("Content-Type", "application/json");

        // Send request with data
        xhttp.send(JSON.stringify(data));
    }

    function submitReceiverInfo() {
        var zip_code = document.getElementById('textbox1').value;
        var blood_group = document.getElementById('textbox11').value;
        var b_type = document.getElementById('receivingType').value;
        var center_id = document.getElementById('textbox2').value;
        var center_name = document.getElementById('textbox3').value;
        var center_address = document.getElementById('textarea2').value;
        var receiver_name = document.getElementById('textbox6').value;
        var receiver_address = document.getElementById('textarea1').value;
        var quantity = document.getElementById('textbox8').value;
        var date = document.getElementById('textbox9').value;
        var type = "receiver";

        if (receiver_name !== "") {
            if (receiver_address !== "") {
                if (quantity > 0 && !isNaN(quantity) && !isNaN(parseFloat(quantity))) {
                    var data = {zip_code: zip_code,
                        blood_group: blood_group,
                        b_type: b_type,
                        center_id: center_id,
                        center_name: center_name, center_address: center_address, receiver_name: receiver_name, receiver_address: receiver_address, quantity: quantity, date: date, type: type};
                    postAjax(data);

                } else {
                    alert("Please enter valid quantity!");
                }

            } else {
                alert("Receiver Address cannot be empty! Please enter your address.");
            }

        } else {
            alert("Receiver Name cannot be empty! Please enter your name.");
        }
    }

    function clear() {
        document.getElementById('textbox1').value = "";
        document.getElementById('textbox11').value = "";
        document.getElementById('receivingType').value = "";
        document.getElementById('textbox2').value = "";
        document.getElementById('textbox3').value = "";
        document.getElementById('textarea2').value = "";
        document.getElementById('textbox6').value = "";
        document.getElementById('textarea1').value = "";
        document.getElementById('textbox8').value = "";
        document.getElementById('textbox9').value = "";
    }
</script>
