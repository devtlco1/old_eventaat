<div class="overflow-hidden content-section" id="create_booking">

    <h2>Create A Booking</h2>
    <?php  $u = 'createBooking';?>

    <pre>
        <code class="bash">
# Here is a curl example
curl \
-H "Accept: application/json" \
-H "Content-Type: application/json" \
-H "Authorization: Bearer XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" \
-X Post {{$ep}}{{$u}} \
-F 'event_id=1' \
-F 'appointment=datetime' \
-F 'adult=2' \
-F 'children=1' \
        </code>
    </pre>
    <p>
        Create a booking using this URL:<br>
        <code class="higlighted break-word">{{$ep}}{{$u}}</code>
    </p>
    <br>
    <pre><code class="json">
Result example :
{
    "result": "success",
    "booking": {
        .......
    }
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
            <td>event_id</td>
            <td>int</td>
            <td>yes</td>
            <td></td>
        </tr>
        <tr>
            <td>appointment</td>
            <td>datetime</td>
            <td>yes</td>
            <td></td>
        </tr>
        <tr>
            <td>adult</td>
            <td>int</td>
            <td>yes</td>
            <td></td>
        </tr>
        <tr>
            <td>children</td>
            <td>int</td>
            <td>yes</td>
            <td></td>
        </tr>
        </tbody>
    </table>

</div>
