<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" href="{{url('backend/uploads/setting/'.$globalData->favicon)}}" type="image/x-icon">
   <link rel="icon" href="{{url('backend/uploads/setting/'.$globalData->favicon)}}" type="image/x-icon">
    <title>Invoice</title>
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/themify.css">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <style type="text/css">
      body{
        font-family: Rubik, sans-serif;
        display: block;
        color: #000248;
      }
      @media print {
    .print-button,
    .download-button {
        display: none;
    }
}

    </style>
  </head>
  <body>
    <table style="width:1160px;margin:0 auto;">
      <tbody> 
        <tr> 
          <td> 
            <table style="width: 100%;">
              <tbody>
                <tr>
                  <td><img src="{{url('backend/uploads/setting/'.$globalData->dark_logo)}}" alt="logo" width="100px">
                    <address style="color: #52526C;opacity: 0.8; width: 40%; margin-top: 10px; font-style:normal;"><span style="font-size: 18px; line-height: 1.5; font-weight: 500;">
                      {{$globalData->address}} </span></address>
                  </td>
                  <td style="color: #52526C;opacity: 0.8; text-align:end;"><span style="display:block; line-height: 1.5; font-size:18px; font-weight:500;">Email : {{$globalData->email}}</span><span style="display:block; line-height: 1.5; font-size:18px; font-weight:500;">Website: {{$globalData->url}}</span><span style="display:block; line-height: 1.5; font-size:18px; font-weight:500;">Contact No : {{$globalData->mobile_number}}</span></td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr> 
          <td> 
            <table style="width:100%;">
              <tbody> 
                <tr style="display:flex;justify-content:space-between;border-top: 1px solid rgba(82, 82, 108, 0.3);border-bottom: 1px solid rgba(82, 82, 108, 0.3);padding: 25px 0;">
                  <td style="display:flex;align-items:center; gap: 6px;"> <span style="color: #52526C;opacity: 0.8; font-size: 18px; font-weight: 500;">Invoice No.</span>
                    <h4 style="margin:0;font-weight:400; font-size: 18px;">#VL25000365</h4>
                  </td>
                  <td style="display:flex;align-items:center; gap: 6px;"> <span style="color: #52526C;opacity: 0.8; font-size: 18px; font-weight: 500;">Date : </span>
                    <h4 style="margin:0;font-weight:400; font-size: 18px;">{{ date('j/m/ Y', strtotime($txndata->payoutcreated_at)) }}</h4>
                  </td>
                  <td style="display:flex;align-items:center; gap: 6px;"> <span style="color: #52526C;opacity: 0.8; font-size: 18px; font-weight: 500;">Payment Status :</span>
                    <h4 style="margin:0;font-weight:400; font-size: 18px;padding:6px 18px;  border-radius: 5px;">{{$txndata->payout_status}}</h4>
                  </td>
                  <td style="display:flex;align-items:center; gap: 6px;"> <span style="color: #52526C;opacity: 0.8; font-size: 18px; font-weight: 500;">Total Amount :</span>
                    <h4 style="margin:0;font-weight:500; font-size: 18px;">₹{{$txndata->amount}}</h4>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr> 
     <td> 
            <table style="width: 100%;">
              <tbody> 
                <tr style="padding: 28px 0; display:block;"> 
                  <td Style="width:63%;"><span style="color: #52526C;opacity: 0.8; font-size: 16px; font-weight: 500;">AGENT DETAILS</span>
                    <h4 style="font-weight:400; margin: 12px 0 6px 0; font-size: 18px;">{{$txndata->agentname}}</h4><span style="width: 54%; display:block; line-height: 1.5; color: #52526C;opacity: 0.8; font-size: 18px; font-weight: 400;">{{$txndata->agentaddress}}</span><span style="line-height:2.6; color: #52526C;opacity: 0.8; font-size: 18px; font-weight: 400;">Phone : {{$txndata->agentmobile}}</span>
                  </td>
                  <td><span style="color: #52526C;opacity: 0.8;font-size: 16px; font-weight: 500;">SENDER DETAILS</span>
                    <h4 style="font-weight:400; margin: 12px 0 6px 0; font-size: 18px;">{{$txndata->name}}</h4><h4 style="font-weight:400; margin: 12px 0 6px 0; font-size: 18px;">Transaction Id: {{$txndata->transactionid}}</h4><span style="width: 95%; display:block; line-height: 1.5; color: #52526C;opacity: 0.8; font-size: 18px; font-weight: 400;">{{$txndata->address}} </span><span style="line-height:2.6; color: #52526C;opacity: 0.8; font-size: 18px; font-weight: 400;">Phone : {{$txndata->mobile_number}}  </span>
                    
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr> 
          <td> 
            <table style="width: 100%;border-collapse: separate;border-spacing: 0;border: 1px solid rgba(82, 82, 108, 0.1)">
              <thead> 
                <tr style="background: #7366FF;border-radius: 8px;overflow: hidden;box-shadow: 0px 10.9412px 10.9412px rgba(82, 77, 141, 0.04), 0px 9.51387px 7.6111px rgba(82, 77, 141, 0.06), 0px 5.05275px 4.0422px rgba(82, 77, 141, 0.0484671);border-radius: 5.47059px;"> 
                  <th style="padding: 18px 15px;text-align: left"><span style="color: #fff; font-size: 18px;">Beneficiary</span></th>
                  <th style="padding: 18px 15px;text-align: left"><span style="color: #fff; font-size: 18px;">Amount</span></th>
                  <th style="padding: 18px 15px;text-align: left"><span style="color: #fff; font-size: 18px;">Chrage</span></th>
                  <th style="padding: 18px 15px;text-align: left"><span style="color: #fff; font-size: 18px;">Total Amount</span></th>
                </tr>
              </thead>
              <tbody>
                <tr style="background-color: rgba(245, 246, 249, 1);box-shadow: 0px 1px 0px 0px rgba(82, 82, 108, 0.15);"> 
                <td style="padding: 18px 15px;"><span style="font-size: 18px;">{{$txndata->name}}</span></td>
                  <td style="padding: 18px 15px;"><span style="font-size: 18px;">₹{{$txndata->amount}}</span></td>
                  <td style="padding: 18px 15px; width: 12%;"> <span style="font-size: 18px;">₹{{$txndata->payout_changes}}</span></td>
                  <td style="padding: 18px 15px; width: 12%;"> <span style="font-size: 18px;">₹{{$txndata->payout_totalamount}}</span></td>

                </tr>
         
              </tbody>
            </table>
          </td>
        </tr>
   

        <tr>
          <td> <span style="display: flex; justify-content: end; gap: 15px;"><a style="background: rgba(115, 102, 255, 1); color:rgba(255, 255, 255, 1);border-radius: 10px;padding: 18px 27px;font-size: 16px;font-weight: 600;outline: 0;border: 0; text-decoration: none;" href="#!" class="print-button" onclick="window.print();">Print Invoice<i class="icon-arrow-right" style="font-size:13px;font-weight:bold; margin-left: 10px;"></i></a><a style="background: rgba(115, 102, 255, 0.1);color: rgba(115, 102, 255, 1);border-radius: 10px;padding: 18px 27px;font-size: 16px;font-weight: 600;outline: 0;border: 0; text-decoration: none;" href="#!" class="download-button" download="">Download<i class="icon-arrow-right" style="font-size:13px;font-weight:bold; margin-left: 10px;"></i></a></span></td>
        </tr>
      </tbody>
    </table>
  </body>
</html>