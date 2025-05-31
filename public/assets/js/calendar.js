let display = document.querySelector(".display");
let days = document.querySelector(".days");
let previous = document.querySelector(".left");
let next = document.querySelector(".right");

let date = new Date();
let year = date.getFullYear();
let month = date.getMonth();
let events = [];

// Fetch events from API
async function fetchEvents() {
    try {
        const response = await fetch('/api/kalender');
        events = await response.json();
        displayCalendar();
    } catch (error) {
        console.error('Error fetching events:', error);
    }
}

// Helper to strip time from a date
function stripTime(date) {
    return new Date(date.getFullYear(), date.getMonth(), date.getDate());
}

function displayCalendar() {
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const firstDayIndex = firstDay.getDay();
    const numberOfDays = lastDay.getDate();

    let formattedDate = date.toLocaleString("en-US", {
        month: "long",
        year: "numeric"
    });

    display.innerHTML = `${formattedDate}`;
    days.innerHTML = ''; // Clear previous days

    // Add empty divs for days before first day of month
    for (let x = 1; x <= firstDayIndex; x++) {
        const div = document.createElement("div");
        div.innerHTML += "";
        days.appendChild(div);
    }

    // Add days of the month
    for (let i = 1; i <= numberOfDays; i++) {
        let div = document.createElement("div");
        let currentDate = new Date(year, month, i);
        div.dataset.date = currentDate.toDateString();
        div.innerHTML += i;

        // Check if there are events on this day (compare only date parts)
        const dayEvents = events.filter(event => {
            const eventStart = stripTime(new Date(event.start));
            const eventEnd = stripTime(new Date(event.end || event.start));
            const current = stripTime(currentDate);
            
            return current >= eventStart && current <= eventEnd;
        });

        if (dayEvents.length > 0) {
            div.classList.add('has-events');
            const eventIndicator = document.createElement('span');
            eventIndicator.className = 'event-indicator';
            // Show all event titles as tooltip on hover
            eventIndicator.title = dayEvents.map(e => e.title).join('\n');
            div.appendChild(eventIndicator);
        }

        // Highlight current date
        if (
            currentDate.getFullYear() === new Date().getFullYear() &&
            currentDate.getMonth() === new Date().getMonth() &&
            currentDate.getDate() === new Date().getDate()
        ) {
            div.classList.add("current-date");
        }

        days.appendChild(div);
    }
}

// Call the function to display the calendar and fetch events
fetchEvents();

previous.addEventListener("click", () => {
    if (month < 0) {
        month = 11;
        year = year - 1;
    }
    month = month - 1;
    date.setMonth(month);
    displayCalendar();
});

next.addEventListener("click", () => {
    if (month > 11) {
        month = 0;
        year = year + 1;
    }
    month = month + 1;
    date.setMonth(month);
    displayCalendar();
});
