<div class="overflow-hidden content-section" id="create_event">

    <h2>Create An Event</h2>
    <?php  $u = 'createAnEvent';?>

    <pre>
        <code class="bash">
# Here is a curl example
curl \
-H "Accept: application/json" \
-H "Content-Type: application/json" \
-H "Authorization: Bearer XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" \
-X Post {{$ep}}{{$u}} \
-F 'restaurant_id=1' \
-F 'title=event 1' \
-F 'discreption=sonthing' \
-F 'starting_at=datetime' \
-F 'ending_at=datetime' \
-F 'old_price=100' \
-F 'price=90' \
-F 'privacy_id=1' \
-F 'seats=100' \
        </code>
    </pre>
    <p>
        Create an event using this URL:<br>
        <code class="higlighted break-word">{{$ep}}{{$u}}</code>
    </p>
    <br>
    <pre><code class="json">
Result example :
{
    "result": "success",
    "event": {
        "title":"event 1",
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
            <td>restaurant_id</td>
            <td>int</td>
            <td>yes</td>
            <td></td>
        </tr>
        <tr>
            <td>title</td>
            <td>string</td>
            <td>yes</td>
            <td></td>
        </tr>
        <tr>
            <td>discreption</td>
            <td>string</td>
            <td>yes</td>
            <td></td>
        </tr>
        <tr>
            <td>starting_at</td>
            <td>datetime</td>
            <td>yes</td>
            <td></td>
        </tr>
        <tr>
            <td>ending_at</td>
            <td>datetime</td>
            <td>yes</td>
            <td></td>
        </tr>
        <tr>
            <td>old_price</td>
            <td>int</td>
            <td>yes</td>
            <td></td>
        </tr>
        <tr>
            <td>price</td>
            <td>int</td>
            <td>yes</td>
            <td></td>
        </tr>
        <tr>
            <td>privacy_id</td>
            <td>int</td>
            <td>yes</td>
            <td></td>
        </tr>
        <tr>
            <td>seats</td>
            <td>int</td>
            <td>yes</td>
            <td></td>
        </tr>
        </tbody>
    </table>

</div>
