window.onload = function() {
    
    // === FUNCTIONS === //
    // ================= //
    // Initialise the interface from local storage data
    customiseFromLocalStorage();
   
        
    // === MAIN EXECUTION === //
    // ====================== //
    // Function to intialise interface from local storage
    function customiseFromLocalStorage() {
        
        // variables to retrived stored data
        var sUserName = localStorage.getItem("sName");
        var sEmailAdd = localStorage.getItem("sEmail");
        
        // Update DOM elements
        document.getElementById("user").innerHTML = sUserName;
        document.getElementById("userEmail").innerHTML = sEmailAdd;
        
    } // end of customiseFromLocalStorage function
    
}