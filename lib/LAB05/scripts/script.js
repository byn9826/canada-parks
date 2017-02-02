window.onload = function() {
    
    // === FUNCTIONS === //
    // ================= //
    
    // Function triggered when the survey form is submitted
    function validateSurvey() {
        
        // Get field validation indicators
        var noName = document.getElementById("no-name");
        var noEmail = document.getElementById("no-email");
        var incorrectPhone = document.getElementById("wrong-phone");
        var noTown = document.getElementById("no-location");
        var noMsg = document.getElementById("no-msg");
        
        
        // Validate required fields from the form
        // --------------------------------------
        // --- Validate Name
        if (frmSurvey.txt_name.value.trim() !== "") {
            objSurveyDetails.sName = frmSurvey.txt_name.value.trim();
            noName.style.display = "none";
        } else {
            noName.style.display = "block";
            frmSurvey.txt_name.focus();
            return false;
        }
        
        // --- Validate email address
        var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if (frmSurvey.txt_email.value.trim() !== "" &&
            emailRegex.test(frmSurvey.txt_email.value.trim())) {
            objSurveyDetails.sEmail = frmSurvey.txt_email.value.trim();
            noEmail.style.display = "none";
        } else {
            if (frmSurvey.txt_email.value.trim() === "") {
                noEmail.innerHTML = "Please enter an email address";
            } else {
                noEmail.innerHTML = "Please enter a valid email address";
            }
            noEmail.style.display = "block";
            frmSurvey.txt_email.focus();
            return false;
        }
        
        // --- Retrieve gender selected
        if (document.getElementById("M").checked) {
            objSurveyDetails.sGender = "M";
        } else {
            objSurveyDetails.sGender = "F";
        }

        // --- Validate provided phone number
        var phoneRegex = /^[0-9]{3}[ |-]?[0-9]{3}[ |-]?[0-9]{4}$/;
        if (frmSurvey.txt_phone.value.trim() !== "") {
            if (phoneRegex.test(frmSurvey.txt_phone.value.trim())) {
                objSurveyDetails.sPhoneNum = frmSurvey.txt_phone.value.trim();
                incorrectPhone.style.display = "none";
            } else {
                incorrectPhone.style.display = "block";
                frmSurvey.txt_phone.focus();
                return false;
            }
        }
        
        // --- Check if a location is selected
        if (frmSurvey.opt_location.value !== "NONE") {
            objSurveyDetails.sLocation = frmSurvey.opt_location.options[frmSurvey.opt_location.selectedIndex].text;
            noTown.style.display = "none";
        } else {
            noTown.style.display = "block";
            frmSurvey.opt_location.focus();
            return false;
        }
        
        // --- Check if user is an international student
        if (document.getElementById("chk_international").checked) {
            objSurveyDetails.fInternational = "Y";
        } else {
            objSurveyDetails.fInternational = "F";
        }
        
        // --- Check if a message is written
        if (frmSurvey.txt_message.value.trim() !== "") {
            objSurveyDetails.sMessage = frmSurvey.txt_message.value.trim();
            noMsg.style.display = "none";            
        } else {
            noMsg.style.display = "block";
            frmSurvey.txt_message.focus();
            return false;
        }
        // --- End of validation ---
        
        // Pass form values to the next page
        localStorage.setItem("sName", objSurveyDetails.sName);
        localStorage.setItem("sEmail", objSurveyDetails.sEmail);
        
    } // end of validateSurvey function
    
    
    // === MAIN EXECUTION === //
    // ====================== //
    
    // Object to store survey details
    var objSurveyDetails = {
        sName: "",
        sEmail: "",
        sGender: "M",
        sPhoneNum: "",
        sLocation: "",
        fInternational: "N",
        sMessage: ""
    };
    
    // Get form element and add submit handler to submit button
    var frmSurvey = document.forms.frmSurvey;
    frmSurvey.onsubmit = validateSurvey;
    
}