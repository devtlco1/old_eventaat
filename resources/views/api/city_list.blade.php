<div class="overflow-hidden content-section" id="city_list">

    <h2>get city list</h2>
    <?php  $u = 'getCityList';?>

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
        Get city list using this URL:<br>
        <code class="higlighted break-word">{{$ep}}{{$u}}</code>
    </p>
    <br>
    <pre><code class="json">
Result example :
{
    "result": "success",
    "cities": [
        {city1},
        {city2},
    ]
}
                </code></pre>
    <h4>NONE QUERY PARAMETERS</h4>

</div>
