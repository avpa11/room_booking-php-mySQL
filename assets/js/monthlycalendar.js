    "use strict";
    var curDay = new Date();

    
    //function that created the clanedar and writes the <table>
    function createCalendar(date) {

      var calendarHTML = "<table id='calendar_table'>";
      calendarHTML += caption(date);
      calendarHTML += tableHead();
      calendarHTML += tableRow(date);
      calendarHTML += "</table>";
      return calendarHTML;
    }

    //function that prints the caption depending on the current month and year
    function caption(date) {
      var monthName = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
      
      var curMonth = date.getMonth();
      
      var curYear = date.getFullYear();
      
      var str = "<caption>" + monthName[curMonth] + " " + curYear + "</caption>";
      
      return str;
    }

    // function that prints the table head
    function tableHead() {
      var days = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];
      var row = "<tr>";
      
      for(var i = 0; i < days.length; i++) {
        row += "<th class='calendar_weekdays'>" + days[i] + "</th>";
      }
      row += "</tr>";
      
      return row;
    }

    // function to determine the length of the month
    function daysInMonth(date) {
      var dayCount = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
      
      var curYear = date.getFullYear();
      var curMonth = date.getMonth();
      
      // to determine the lead year and 29 days in February
      if(curYear % 4 == 0) { 
        if( (curYear % 100 != 0) || (curYear % 400 == 0) ) {
          dayCount[1] = 29;	
        }
      }
      
      return dayCount[curMonth];
    }

    // prints the table rows and days in month
    function tableRow(date) {
      var day = new Date(date.getFullYear(), date.getMonth(), 1);
      var weekDay = day.getDay();  
      
      var html = "<tr>";
      for(var i = 0; i < weekDay; i++) {
        html += "<td></td>";
      }
      
      
      var totalDays = daysInMonth(date);
      
      var today = date.getDate();
      
      for(var i = 1; i <= totalDays; i++) {
        day.setDate(i);
        weekDay = day.getDay();
        
        // starts new row if the weekday is Sun
        if(weekDay === 0){
          html += "<tr>";
        }
        // special condition to highlight the current day through css
        if(i === today) {
          html += "<td class='calendar_dates' id='calendar_today'>" + i + "</td>";
        } else {
          html += "<td class='calendar_dates'>" + i + "</td>";
        }
        
        // finishes the row if the weekday is Sat
        if(weekDay === 6){
          html += "</tr>";
        }

        
      }
      
      return html;
      
    }
