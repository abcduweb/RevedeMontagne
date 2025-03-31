$(document).ready(function() {
// Function to change form action.
$("#db").change(function() {
var selected = $(this).children(":selected").text();
switch (selected) {
case "Randonnées pédestre":
$("#myform").attr('action', 'ajouter-un-topo-de-randonnees-{ids}.html');
//alert("Vous avez selectionné Randonnée pédestre");
break;
case 7:
$("#myform").attr('action', 'oracle.html');
//alert("Form Action is Changed to 'oracle.html'n Press Submit to Confirm");
break;
case "7":
$("#myform").attr('action', 'msaccess.html');
alert("Form Action is Changed to 'msaccess.html'n Press Submit to Confirm");
break;
default:
$("#myform").attr('action', '#');
}
});
// Function For Back Button
$(".back").click(function() {
parent.history.back();
return false;
});
});