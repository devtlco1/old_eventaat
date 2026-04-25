<div class="overflow-hidden content-section" id="my_profile">

    <h2>get my profile</h2>
    <?php  $u = 'getMyProfile';?>

    <pre>
        <code class="bash">
# Here is a curl example
curl \
-H "Accept: application/json" \
-H "Content-Type: application/json" \
-H "Authorization: Bearer XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" \
-X GET {{$ep}}{{$u}} \
        </code>
    </pre>
    <p>
        To get user profile use bearer token with this URL:<br>
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
    <h4>NONE QUERY PARAMETERS</h4>

</div>
