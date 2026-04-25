<div class="overflow-hidden content-section" id="get_event_bookings">

    <h2>Get An Event Bookings</h2>
    <?php  $u = 'getAnEventBookings';?>

    <pre>
        <code class="bash">
# Here is a curl example
curl \
-H "Accept: application/json" \
-H "Content-Type: application/json" \
-H "Authorization: Bearer XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" \
-X Post {{$ep}}{{$u}} \
-F 'event_id=1' \
        </code>
    </pre>
    <p>
        Get an event booking list using this URL:<br>
        <code class="higlighted break-word">{{$ep}}{{$u}}</code>
    </p>
    <br>
    <pre><code class="json">
Result example :
{
    "result": "success",
    "bookings": [{book1},{book2},],
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
        </tbody>
    </table>

</div>
