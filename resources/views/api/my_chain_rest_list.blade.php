<div class="overflow-hidden content-section" id="my_chain_rest_list">

    <h2>get my chain restaurants list</h2>
    <?php  $u = 'getMyChainRestaurants';?>

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
        for restaurant admin to get his chain restaurant list using this URL:<br>
        <code class="higlighted break-word">{{$ep}}{{$u}}</code>
    </p>
    <br>
    <pre><code class="json">
Result example :
{
    "result": "success",
    "restaurants": [
        {rest1},
        {rest2},
    ]
}
                </code></pre>
    <h4>NONE QUERY PARAMETERS</h4>

</div>
