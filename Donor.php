<html>
    <head>
        <title>
            Welcome Donor
        </title>
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
        <div id="div1" style="background-image: url('img2.jpg'); background-size: 1410px 700px; height: 750px">
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
                            <th class="pageHeading"><b><p><u>Donor Information</u></p></b></th>
                        </tr>
                        <tr>
                            <td style="padding-top: 10px">Please provide the information below to check your nearest Blood donation Center:</td>
                        </tr>
                    </tbody>
                </table>
                <div id="div3" class="divBox" style="padding-bottom: 10px">
                    <label>Zip Code: </label>
                    <input type="text" id="textbox1"/>
                    <button id="btn1" onclick="loadDonorCenter()"><b>Check Availability</b></button>
                </div>
                <div id="displayTable" style="display: none">
                    <div id=""div5" style="padding-top: 30px">Please provide the information below to book appointment:</div>
                    <div id="div6" class="divBox">  
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
                                        <textarea id="textarea1" rows="5" cols="35" readonly></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>*Donor Name: </label>
                                    </td>
                                    <td>
                                        <input type="text" id="textbox6" placeholder="Enter your name"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>*Donor Address: </label>
                                    </td>
                                    <td>
                                        <textarea id="textarea2" rows="5" cols="35" placeholder="Enter your address"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>*Donor Blood Group: </label>
                                    </td>
                                    <td>
                                        <input type="text" id="textbox7" placeholder="Enter your Blood group"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>*Donation Type: </label>
                                    </td>
                                    <td>
                                        <select id="donationType">
                                            <option value="Whole Blood">Whole Blood</option>
                                            <option value="Red Blood Cells">Red Blood Cells</option>
                                            <option value="Platelet">Platelet</option>
                                            <option value="Plasma">Plasma</option>
                                        </select>
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
                                        <input type="text" id="textbox9" placeholder="dd-mm-yyyy"/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="padding-left: 100px; padding-top: 10px; padding-bottom: 10px">
                            <button id="btn2" onclick="sendDonorData()"><b>Submit</b></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body> 
</html>
<script>

    function postAjax(data) {
        var xhttp = new XMLHttpRequest();
        // Set POST method and ajax file path
        xhttp.open("POST", "ajaxfile.php", true);

        // call on request changes state
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(response);

                var response = this.responseText;
                if (response == 1) {
                    alert("Thanks Donor. Information saved successfully.");
                }
            }
        };

        // Content-type
        xhttp.setRequestHeader("Content-Type", "application/json");

        // Send request with data
        xhttp.send(JSON.stringify(data));
    }

    function sendDonorData() {
        var zip_code = document.getElementById('textbox1').value;
        var center_id = document.getElementById('textbox2').value;
        var center_name = document.getElementById('textbox3').value;
        var center_address = document.getElementById('textarea1').value;
        var donor_name = document.getElementById('textbox6').value;
        var donor_address = document.getElementById('textarea2').value;
        var donor_blood_group = document.getElementById('textbox7').value;
        var donation_type = document.getElementById('donationType').value;
        var quantity = document.getElementById('textbox8').value;
        var date = document.getElementById('textbox9').value;
        var type = "donor";

        if (donor_name !== "") {
            if (donor_address !== "") {
                if (donor_blood_group === "A+" || donor_blood_group === "a+" ||
                        donor_blood_group === "A-" || donor_blood_group === "a-" ||
                        donor_blood_group === "B+" || donor_blood_group === "b+" ||
                        donor_blood_group === "B-" || donor_blood_group === "b-" ||
                        donor_blood_group === "AB+" || donor_blood_group === "ab+" ||
                        donor_blood_group === "AB-" || donor_blood_group === "ab-" ||
                        donor_blood_group === "O+" || donor_blood_group === "o+" ||
                        donor_blood_group === "O-" || donor_blood_group === "o-") {
                    if (quantity > 0 && !isNaN(quantity) && !isNaN(parseFloat(quantity))) {
                        var data = {zip_code: zip_code,
                            center_id: center_id,
                            center_name: center_name,
                            center_address: center_address,
                            donor_name: donor_name, donor_address: donor_address, donor_blood_group: donor_blood_group, donation_type: donation_type, quantity: quantity, date: date, type: type};
                        postAjax(data);
                        clear();
                        document.getElementById("displayTable").style.display = 'none';
                    } else {
                        alert("Please enter valid quantity!");
                    }
                } else
                {
                    alert("Please enter valid blood group!");
                }
            } else {
                alert("Donor Address cannot be empty! Please enter your address.");
            }

        } else {
            alert("Donor Name cannot be empty! Please enter your name.");
        }
    }

    function loadDonorCenter() {

        var xhttp = new XMLHttpRequest();

        var zip_code = document.getElementById('textbox1').value;

        // Set GET method and ajax file path with parameter
        xhttp.open("GET", "ajaxfile.php?request=1&&zipCode=" + zip_code + "&&type=donor", true);

        // Content-type
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        // call on request changes state
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                // Parse this.responseText to JSON object
                var response = JSON.parse(this.responseText);

                if (response && response.length) {
                    document.getElementById("textbox2").value = response[0].Center_ID;
                    document.getElementById("textbox3").value = response[0].Center_Name;
                    document.getElementById("textarea1").value = response[0].Center_Address;
                    document.getElementById("displayTable").style.removeProperty('display');
                } else {
                    alert("Zip code not available! Please enter valid zip code.");
                }
            }
        };

        // Send request
        xhttp.send();
    }

    function clear() {
        document.getElementById('textbox1').value = "";
        document.getElementById('textbox2').value = "";
        document.getElementById('textbox3').value = "";
        document.getElementById('textarea1').value = "";
        document.getElementById('textbox6').value = "";
        document.getElementById('textarea2').value = "";
        document.getElementById('textbox7').value = "";
        document.getElementById('donationType').value = "";
        document.getElementById('textbox8').value = "";
        document.getElementById('textbox9').value = "";
    }
</script>
