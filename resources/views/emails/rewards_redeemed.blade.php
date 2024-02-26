<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Redeemed an Item</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>A User has redeemed an item</h2>
    <p>Hello {{ $workorder->users->name }},</p>
    <p>The User, {{}} has redeemed an Item with the following details</p>
    <table>
        <tr>
            <th>Item</th>
            <td>{{ }}</td>
        </tr>
        <tr>
            <th>Quantity</th>
            <td>{{  }}</td>
        </tr>
        <tr>
            <th>Points</th>
            <td>{{  }}</td>
        </tr>
        <tr>
            <th>Redeemed at</th>
            <td>{{  }}</td>
        </tr>
        <!-- Add other fields as required -->
    </table>
    <p>Please ready the items redeemed by user as soon as possible</p>
    <p>For detailed information or any updates, please visit the portal.</p>
</body>
</html>
