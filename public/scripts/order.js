var lstEtat = document.getElementById("etat");

lstEtat.addEventListener(function() {
    var options = lstEtat.querySelectorAll("option");
    var count = options.length;
    if(typeof(count) === "undefined" || count < 2)
    {
        addActivityItem();
    }
});

lstEtat.addEventListener("change", function() {
    if(lstEtat.value == "addNew")
    {
        addActivityItem();
    }
});

function addActivityItem() {
    // ... Code to add item here
}
