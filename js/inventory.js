'use strict'
//https://blainerobertson.github.io/340br/phpmotors/views/select-products-js.html
// Get a list of vehicles in inventory based on the classificationId 
let classificationList = document.querySelector("#classificationList");
classificationList.addEventListener("change", function () {
    let classificationId = classificationList.value;
    console.log(`classificationId is: ${classificationId}`);
    let classIdURL = "/phpmotors/vehicles/index.php?action=getInventoryItems&classificationId=" + classificationId;
    fetch(classIdURL)
        .then(function (response) {
            if (response.ok) {
                return response.json();
            }
            throw Error("Network response was not OK");
        })
        .then(function (data) {
            console.log(data);
            buildInventoryList(data);
        })
        .catch(function (error) {
            console.log('There was a problem: ', error.message)
        })
})


// Build inventory items into HTML table components and inject into DOM 
function buildInventoryList(data) {
    let inventoryDisplay = document.getElementById("inventoryDisplay");
    // Set up the table labels 
    let dataTable = '<thead>';
    dataTable += '<tr><th colspan="100%">Vehicle Name</th></tr>';
    dataTable += '</thead>';
    // Set up the table body 
    dataTable += '<tbody>';
    // Iterate over all vehicles in the array and put each in a row 
    data.forEach(function (element) {
        console.log(element.invId + ", " + element.invModel);
        dataTable += `<tr><td>${element.invMake} ${element.invModel}</td>`;
        dataTable += `<td><a href='/phpmotors/vehicles?action=mod&invId=${element.invId}' title='Click to modify'>Modify</a></td>`;
        dataTable += `<td><a href='/phpmotors/vehicles?action=del&invId=${element.invId}' title='Click to delete'>Delete</a></td></tr>`;
    })
    dataTable += '</tbody>';
    // Display the contents in the Vehicle Management view 
    inventoryDisplay.innerHTML = dataTable;
}

/* Nevermind, I would have to rewrite the beginning code in this file and I don't have time for that
// Build vehicle display page
function buildVehicleDisplay(data) {
    let vehicleDisplay = document.getElementById("vehicleDisplay");
    // Set up the table labels 
    let dataTable = '<thead>';
    dataTable += '<tr><th colspan="100%">Vehicle Information</th></tr>';
    dataTable += '</thead>';
    // Set up the table body 
    dataTable += '<tbody>';
    // Iterate over all vehicles in the array and put each in a row 
    data.forEach(function (element) {
        console.log(element.invId + ", " + element.invModel);
        dataTable += `<tr><td>${element.invMake}</td>`;
        dataTable += `<tr><td>${element.invModel}</td>`;
        dataTable += `<tr><td>${element.invDescription}</td>`;
        dataTable += `<tr><td>${element.invPrice}</td>`;
        dataTable += `<tr><td>${element.invColor}</td>`;
        dataTable += `<tr><td>${element.invStock}</td>`;
    })
    dataTable += '</tbody>';
    // Display the contents in the Vehicle Management view 
    vehicleDisplay.innerHTML = dataTable;
}*/