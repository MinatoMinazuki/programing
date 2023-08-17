function switchToMonthly() {
  document.getElementById("monthly-calendar").style.display = "block";
  document.getElementById("weekly-calendar").style.display = "none";
}

function switchToWeekly() {
  document.getElementById("monthly-calendar").style.display = "none";
  document.getElementById("weekly-calendar").style.display = "block";
}
