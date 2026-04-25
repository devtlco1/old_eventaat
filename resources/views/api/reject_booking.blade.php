<div class="overflow-hidden content-section" id="reject_booking">

    <h2>Reject Booking</h2>
    <?php  $u = 'rejectBooking';?>

    <pre>
        <code class="bash">
# Here is a curl example
curl \
-H "Accept: application/json" \
-H "Content-Type: application/json" \
-H "Authorization: Bearer XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" \
-X Post {{$ep}}{{$u}} \
-F 'booking_id=1' \
        </code>
    </pre>
    <p>
        Reject the booking using this URL:<br>
        <code class="higlighted break-word">{{$ep}}{{$u}}</code>
    </p>
    <br>
    <pre><code class="json">
Result example :
{
    "result": "success",
}
                </code></pre>


    <h4>QUERY PARAMETERS</h4>
    <table class="central-overflow-x">
        <thead>
        <tr>
            <th>Field</th>
            <th>Type</th>
            <th>required</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>booking_id</td>
            <td>int</td>
            <td>yes</td>
            <td></td>
        </tr>
        </tbody>
    </table>

</div>
