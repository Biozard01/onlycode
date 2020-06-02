var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();
var HH = today.getHours();
var MM = today.getMinutes();

if (dd < 10) {
    dd = '0' + dd
}
if (mm < 10) {
    mm = '0' + mm
}

today = yyyy + '-' + mm + '-' + dd + 'T' + HH + ':' + 'MM';
document.getElementById("ann_expire_time").setAttribute("min", today);