@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">

<!-- jQuery (Required for FullCalendar) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

@section('content')

<h2 style="text-align:center">Student Payment Calendar</h2>
<div id="calendar"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
    
        if (calendarEl) {
            var events = @json($paymentDates);

            // Customize events rendering
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: events
            });
    
            calendar.render();
        } else {
            console.error("Calendar element not found!");
        }
    });
</script>

@endsection