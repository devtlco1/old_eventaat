<div class="overflow-hidden content-section" id="chain_offer_list">

    <h2>get Restaurant offer list</h2>
    <?php  $u = 'getChainOffers';?>

    <pre>
        <code class="bash">
# Here is a curl example
curl \
-H "Accept: application/json" \
-H "Content-Type: application/json" \
-H "Authorization: Bearer XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" \
-X GET {{$ep}}{{$u}} \
-F 'chain_id=1' \
        </code>
    </pre>
    <p>
        Get chain restaurants offer list using this URL:<br>
        <code class="higlighted break-word">{{$ep}}{{$u}}</code>
    </p>
    <br>
    <pre><code class="json">
Result example :
{
    "result": "success",
    "offers": [
        {rest1:{offers:[{offer1,offer2}]}},
        {rest2:{offers:[{offer1,offer2}]}},
    ]
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
            <td>chain_id</td>
            <td>int</td>
            <td>yes</td>
            <td></td>
        </tr>
        </tbody>
    </table>


</div>
