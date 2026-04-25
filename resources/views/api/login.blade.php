<div class="overflow-hidden content-section" id="login">

    <h2>login</h2>
    <?php  $u = 'login';?>

    <pre>
        <code class="bash">
# Here is a curl example
curl \
-H "Accept: application/json" \
-H "Content-Type: application/json" \
-X POST {{$ep}}{{$u}} \
-F 'token=client_FCM_token' \
-F 'otp_code=******' \
        </code>
    </pre>
    <p>
        After your user sent code over whatsapp you can login using this URL:<br>
        <code class="higlighted break-word">{{$ep}}{{$u}}</code>
    </p>
    <br>
    <pre><code class="json">
Result example :
{
    "result": "success",
    "Access-Token": "****************",
    "User": {
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
            <td>token</td>
            <td>String</td>
            <td>yes</td>
            <td>FCM token</td>
        </tr>
        <tr>
            <td>otp_code</td>
            <td>String</td>
            <td>yes</td>
            <td>OTP</td>
        </tr>
        </tbody>
    </table>
</div>
