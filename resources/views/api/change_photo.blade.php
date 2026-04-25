<div class="overflow-hidden content-section" id="change_my_photo">

    <h2>change profile photo</h2>
    <?php  $u = 'changeMyPhoto';?>

    <pre>
        <code class="bash">
# Here is a curl example
curl \
-H "Accept: application/json" \
-H "Content-Type: application/json" \
-H "Authorization: Bearer XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" \
-X Post {{$ep}}{{$u}} \
-F 'img=FILE' \
        </code>
    </pre>
    <p>
        To change profile image using this URL:<br>
        <code class="higlighted break-word">{{$ep}}{{$u}}</code>
    </p>
    <br>
    <pre><code class="json">
Result example :
{
    "result": "success",
    "image_url": "http.....",
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
            <td>img</td>
            <td>file</td>
            <td>yes</td>
            <td></td>
        </tr>
        </tbody>
    </table>

</div>
