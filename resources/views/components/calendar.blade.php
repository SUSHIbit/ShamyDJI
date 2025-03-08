@props(['bookings' => [], 'cameraId', 'selectable' => true])

<div id="calendar-{{ $cameraId }}" class="calendar-container"></div>

{{-- Hidden JSON data for bookings --}}
<div id="bookings-data-{{ $cameraId }}" style="display: none;">
    @json($bookings)
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar-{{ $cameraId }}');
        const bookingsData = JSON.parse(document.getElementById('bookings-data-{{ $cameraId }}').textContent);
        
        // Format bookings for FullCalendar
        const events = bookingsData.map(booking => ({
            title: 'Booked',
            start: booking.start_date,
            end: new Date(new Date(booking.end_date).setDate(new Date(booking.end_date).getDate() + 1)), // End date is exclusive in FullCalendar
            color: '#EF4444', // Red color for booked dates
            allDay: true
        }));
        
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            selectable: {{ $selectable ? 'true' : 'false' }},
            selectAllow: function(selectInfo) {
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                return selectInfo.start >= today;
            },
            events: events,
            select: function(info) {
                @auth
                    @if(auth()->user()->role === 'client')
                        // Format dates for URL
                        const startStr = info.startStr;
                        const endDate = new Date(info.end);
                        endDate.setDate(endDate.getDate() - 1); // Adjust because end date is exclusive in FullCalendar
                        const endStr = endDate.toISOString().split('T')[0];
                        
                        window.location.href = `/client/cameras/{{ $cameraId }}/book?start_date=${startStr}&end_date=${endStr}`;
                    @endif
                @else
                    alert('Please login to book this camera');
                    calendar.unselect();
                @endauth
            },
            eventDidMount: function(info) {
                // Add tooltip to show booking details
                const tooltip = new Tooltip(info.el, {
                    title: 'This date is already booked',
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body'
                });
            }
        });
        
        calendar.render();
    });
</script>
@endpush