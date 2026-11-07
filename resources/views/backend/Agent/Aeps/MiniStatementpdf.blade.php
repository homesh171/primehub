<!DOCTYPE html>
<html lang="en">
<head>
  <title>MiniStatement</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>


<div style="width: 100%; padding: 20px;">
    <div style="border-top: 2px solid #005192; padding: 10px 0; display: flex; align-items: center; justify-content: space-between;">
      <img src="{{url('backend/uploads/setting/'.$globalData->dark_logo)}}" style="width: 105px;" alt="Bank Logo 1">
    </div>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #3a3737;">
      <thead>
        <tr>
          <td colspan="4" style="border: 1px solid #3a3737; padding: 8px; color: #ababab; font-size: 22px;">MiniStatement</td>
        </tr>
      </thead>
      <tbody>
    <tr>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Date:</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">{{date('j M y',strtotime($aepsMiniStatement->timestamp))}}</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Time:</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">{{date('H:i:s',strtotime($aepsMiniStatement->timestamp))}}</td>
        </tr>
        <tr>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">BC Name:</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">{{$userdata->name}}</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Agent Id:</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">{{$userdata->agent_id}}</td>
        </tr>
        <tr>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">BC Mobile:</td>
          <td colspan="3" style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">{{$userdata->mobile_number}}</td>
        </tr>
        <tr>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Customer Aadhaar/VID No:</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">{{$aepsMiniStatement->adhaarnumber}}</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Bank Name:</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">{{$bankname}}</td>
        </tr>
        <tr>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Transaction Id:</td>
          <td colspan="3" style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">{{$aepsMiniStatement->referenceno}}</td>
        </tr>
        <tr>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">RRN:</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">{{$responseDatapdfs['bankrrn']}}</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Transaction Status:</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #0daa0d; font-size: 16px; font-weight: 600;">{{$responseDatapdfs['message']}}</td>
        </tr>

	<tr>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Account Balance:</td>
          <td colspan="3" style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">{{$responseDatapdfs['balanceamount']}}</td>
        </tr>
    </tbody>
  </table>
  	<table style="border-collapse: collapse; width: 100%; border: 1px solid #3a3737;">
		<thead>
			<tr>
				<th style="border: 1px solid #3a3737; font-size: 18px; background-color: #f8f9fa; padding: 0.5rem;">date </th>
				<th style="border: 1px solid #3a3737; font-size: 18px; background-color: #f8f9fa; padding: 0.5rem;">descr </th>
				<th style="border: 1px solid #3a3737; font-size: 18px; background-color: #f8f9fa; padding: 0.5rem;">txntype </th>
				<th style="border: 1px solid #3a3737; font-size: 18px; background-color: #f8f9fa; padding: 0.5rem;">amount </th>
			</tr>
		</thead>
		<tbody>
		    @foreach ($responseDatapdf['transactions'] as $transaction)
            
                <tr>
                    <td style="border: 1px solid #3a3737; padding: 0.5rem;">{{ $transaction['date'] }}</td>
                      <td style="border: 1px solid #3a3737; padding: 0.5rem;">{{ $transaction['narration'] }}</td>
                    <td style="border: 1px solid #3a3737; padding: 0.5rem;">{{ $transaction['txnType'] }}</td>
                    <td style="border: 1px solid #3a3737; padding: 0.5rem;">{{ $transaction['amount'] }}</td>
                  
                </tr>
            @endforeach
			
		</tbody>
	</table>
  
</div>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
