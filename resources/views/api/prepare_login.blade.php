<div class="overflow-hidden content-section" id="prepareLogin">

    <h2>prepare client login</h2>
    <?php  $u = 'prepareLogin';?>

    <pre>
        <code class="bash">
# Here is a curl example
curl \
-H "Accept: application/json" \
-H "Content-Type: application/json" \
-X POST {{$ep}}{{$u}} \
-F 'token=client_FCM_token' \
        </code>
    </pre>
    <p>
        The first step to login you should request an otp code using this URL:<br>
        <code class="higlighted break-word">{{$ep}}{{$u}}</code>
    </p>
    <br>
    <pre><code class="json">
Result example :
{
    "result": "success",
    "code": "6#dA66RDc1"
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
            <td>token</td>
            <td>String</td>
            <td>yes</td>
            <td>FCM token</td>
        </tr>
        </tbody>
    </table>
</div>
