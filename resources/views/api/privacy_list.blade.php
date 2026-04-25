<div class="overflow-hidden content-section" id="privacy_list">

    <h2>get privacy list</h2>
    <?php  $u = 'getPrivacyOptions';?>

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
        Get privacy list using this URL:<br>
        <code class="higlighted break-word">{{$ep}}{{$u}}</code>
    </p>
    <br>
    <pre><code class="json">
Result example :
{
    "result": "success",
    "privacy": [
        {p1},
        {p2},
    ]
}
                </code></pre>
    <h4>NONE QUERY PARAMETERS</h4>

</div>
