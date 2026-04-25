<div class="overflow-hidden content-section" id="change_my_name">

    <h2>change profile name</h2>
    <?php  $u = 'changeMyName';?>

    <pre>
        <code class="bash">
# Here is a curl example
curl \
-H "Accept: application/json" \
-H "Content-Type: application/json" \
-H "Authorization: Bearer XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" \
-X Post {{$ep}}{{$u}} \
-F 'name=tamer' \
        </code>
    </pre>
    <p>
        To change profile name using this URL:<br>
        <code class="higlighted break-word">{{$ep}}{{$u}}</code>
    </p>
    <br>
    <pre><code class="json">
Result example :
{
    "result": "success",
    "user": {
        "name":"test",
        "mobile":"....",
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
            <td>name</td>
            <td>string</td>
            <td>yes</td>
            <td></td>
        </tr>
        </tbody>
    </table>

</div>
