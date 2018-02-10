function richtigesdatum(dateStr) {
var datePat = /^(\d{1,2})(\/|.)(\d{1,2})\2(\d{4})$/; // requires 4 digit year
var matchArray = dateStr.match(datePat); // is the format ok?
if (matchArray == null) {
alert(unescape("Ihre Datumseingabe ist ung%FCltig%21"))
return false;
}
month = matchArray[3]; // parse date into variables
day = matchArray[1];
year = matchArray[4];
if (month < 1 || month > 12) { // check month range
alert("Bitte geben Sie einen Monat zwischen 01 und 12 an!");
return false;
}
if (day < 1 || day > 31) {
alert("Bitte geben Sie einen Tag zwischen 1 and 31 an!");
return false;
}
if ((month==4 || month==6 || month==9 || month==11) && day==31) {
alert("Der ausgew‰hlte Monat "+month+" hat keine 31 Tage!")
return false;
}
if (month == 2) { // check for february 29th
var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
if (day>29 || (day==29 && !isleap)) {
alert("Der Februar im Jahr " + year + " hat keine " + day + " Tage!");
return false;
 }
}
return true;
}
function datumanzeige(dateObj) {
month = dateObj.getMonth()+1;
month = (month < 10) ? "0" + month : month;
day = dateObj.getDate();
day = (day < 10) ? "0" + day : day;
year = dateObj.getYear();
if (year < 2000) year += 1900;
return (day + "." + month + "." + year);
}
function fruchtbarkeitberechnen(pregform) {
periode = new Date(); // creates new date objects
ovulation = new Date();
erstertag = new Date();
letztertag = new Date()
today = new Date();
kurz = 0, lang = 0; // sets variables to invalid state ==> 0
if (richtigesdatum(pregform.periode.value)) { // Validates menstual date 
periodeinput = new Date(pregform.periode.value);
periode.setTime(periodeinput.getTime())
}
else return false; // otherwise exits
kurz = (pregform.kurz.value == "" ? 28 : pregform.kurz.value); // defaults to 28
// validates kurz range, from 22 to 45
if (pregform.kurz.value != "" && (pregform.kurz.value < 22 || pregform.kurz.value > 45)) {
alert("Ihre Zyklusdauer ist entweder zu kurz oder zu lang \n"
+ "um den wahrscheinlichen Eisprung richtig zu berechnen! Die Berechnung \n"
+ "wird dennoch mit Ihren Daten erfolgen. ");
}
lang = (pregform.lang.value == "" ? 28 : pregform.lang.value); // defaults to 28
// validates lang range, from 22 to 45
if (pregform.lang.value != "" && (pregform.lang.value < 22 || pregform.lang.value > 45)) {
alert("Ihre Zyklusdauer ist entweder zu kurz oder zu lang \n"
+ "um den wahrscheinlichen Eisprung richtig zu berechnen! Die Berechnung \n"
+ "wird dennoch mit Ihren Daten erfolgen. ");
}
// sets ovulation date to periode date + kurz days - lang days
// the '*86400000' is necessary because date objects track time
// in milliseconds; 86400000 milliseconds equals one day
var periodeTime = (month + "/" + day + "/" + year)
ovulation.setTime((Date.parse(periodeTime)) + (14*86400000));
pregform.eisprung.value = datumanzeige(ovulation);
// erster fruchtbarer Tag= Beginn der Periode + (kürzester Zyklus -18) Tage
erstertag.setTime((Date.parse(periodeTime)) + ((kurz-18)*86400000));
pregform.erstertag.value = datumanzeige(erstertag);
// erster fruchtbarer Tag= Beginn der Periode + (kürzester Zyklus -18) Tage
letztertag.setTime((Date.parse(periodeTime)) + ((lang-11)*86400000));
pregform.letztertag.value = datumanzeige(letztertag);
return false; // form should never submit, returns false
}