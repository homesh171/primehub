

@php

$userId = Crypt::decrypt(Route::current()->parameter('id'));

$userdata = App\Models\Agent::where('id',$userId)->first();

@endphp

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<title>
	{{$globalData->site_title}}
</title>
    <style type="text/css">
        .main_part
        {
            min-height: 630px;
        }
        .top_menu
        {
            width: 15% !important;
        }
        #ctl00_updLogin
        {
            width: 100%;
        }
        .btn.btn-primary.dropdown-toggle
        {
            background: #008e00;
        }
        .fa.fa-user
        {
            padding-right: 5px;
        }
        .btn.btn-primary.dropdown-toggle.loginbtn
        {
            background: unset;
            color: #666;
            border: unset;
        }
        .top_menu
        {
            width: 20% !important;
        }
        .top_menu .dropdown
        {
            display: inline-block;
            float: left;
        }
        .top_menu ul li
        {
            margin-top: 7px !important;
            border-left: 1px solid;
            padding-left: 10px;
        }
    </style>
    <link href="{{url('useragreement/css/NewDesignCss/css/stylesheet.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('useragreement/css/NewDesignCss/NewDesignCss/css/tabcontent.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('useragreement/css/NewDesignCss/NewDesignCss/css/responsive.css')}}" rel="stylesheet" type="text/css" />
   
    <link href="{{url('useragreement/css/NewDesignCss/css/style2.css')}}" rel="stylesheet" type="text/css" />
  
    
<link rel="stylesheet"  href="Portal/css/genfonts/Roboto.css">
<style>
.about_us p{line-height:1.4em; text-align:justify;}
.about_us{ margin-top:2%; margin-bottom:2%;}
.shead{ text-align:center !important;}
.fotter_bottom p{  text-align:center !important; }
</style>
<style type="text/css">
body {
    font-family: 'Roboto', sans-serif;
    font-size: 14px;
    color: #000;
    text-transform: capitalize;
    line-height: 35px;
}
.underline { text-decoration: underline; }

input {
    line-height: normal;
    border: unset; text-transform: capitalize;
    border-bottom: 1px solid #3336; padding: 10px;
}
.mainbx .innerbx {
    border: 1px solid #eee;
    padding: 15px 30px;
    /* padding-top: 0px; */
}
b.shead {
    background: #eee;
    float: left;
    width: 100%;
    padding: 10px 10px;
    margin-bottom: 15px;margin-top: 15px;
}

input:focus { outline: none; background-color: #eee; }
.txtbx textarea {
    overflow: auto;
    width: 100%;
}

h1, h2, h3, h4, h5, h6 {
    font-weight: 700;
    color: #333;
}
.h2, h2 {

    font-weight: 300;
}
.mainbx {
    float: left;
    width: 100%;
    padding-bottom: 5%;
}
.heading {
    background: #eeeeeea3;
    padding: 10px;
}
h4{margin: 30px auto -40px;
text-align: center;}


@media print {
            .no-print {
                display: none !important;
                background:none !important;
            }
            
            a[href]:after {
        content: none !important;
    }
     
       @page {
            margin-top: 0;
            margin-bottom: 0;
       }
       body {
           padding-top: 72px;
           padding-bottom: 72px ;
       }
   }
}
</style>
</head>
<body>

    <div id="wrapper">

        
<div id="mydata">

<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row mx-0">
                    <div class="col-lg-12 col-md-12">
                        <div class="">
                            <div class=" text-end">
                                <h4 class="ribbon">
                                    Franchise Agreement
                                </h4>
                                <div class="card-header-left">
                                    <button class="btn btn-success no-print" ><a style="color:#fff;" href="{{route('agent.index')}}">Back</a></button>
                                    <button class="btn btn-danger no-print" onclick="window.print()">Download</button>
                                </div>
                            </div>
                            <div >
                            </div>
                         
                            <div>
                                <div class="">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <article>
            
            <div class="heading text-center">
              <h1>Facilitator Franchise Agreement</h1>
              <h2>Terms & Conditions for Franchisee</h2>
            </div>
            <br>
            <p>Welcome to <b>{{$globalData->site_title}}!   The Franchisor, {{$globalData->site_title}} operates and facilitates certain services under a brand as “{{$globalData->site_title}} “.</b></p>
            <p>Thank you for using and appreciating our products and service (services).</p>
            <p>The Services are provided by <b>FRANCHISOR</b>, located at <b> {{$globalData->address}}</b></p>
            <p>If you start using any of our Services, it is presumed that the terms and conditions related to that service is accepted by you and you are agreeing/accepting these terms and conditions. So Please read all documents carefully before accepting.</p>
            <p>                      When you use Franchisor Group’s services through our Website or by Mobile Application you will be governed by the following terms and conditions (Terms) which are incorporated herein by way of reference. We are only the facilitator. These terms and conditions are effective after acceptance of usage through franchisor’s platform, and these terms and conditions are governs the relationship between the users of this platform (“You”, “Your”, “Yours” or the “User” as the context may necessitate) and Franchisor (“Us”, “Our” or “We”) as the context may necessitate.</p>
            <br>
            <h4>ACCEPTANCE OF TERMS:-</h4>
            <br>
            <br>
            <p>By accepting the Terms and conditions, you understand and agree that franchisor will treat your usage of services such as prepaid mobile/DTH recharge purchasing services or services regarding bill payments, money transfer or services regarding our online marketplace or such other services which may be added from time to time (all such services are individually or collectively referred as Service or Services) on our any website, mobile Platform/Network and mobile application (Related Applications).</p>
            <p>Service can be used by you, subject to your adherence with the terms and conditions set forth including relevant policies. Franchisor reserves the right, at its sole discretion, to revise, add, or delete portion/s of these terms and conditions any time without further notice. You shall re-visit the www.primehubsofttechsolutions.com “Terms & Conditions” page time to time to stay abreast of any changes that the “Site” may introduce.</p>
            <p>If you do not agree to the terms and conditions of any policy, please do not use or access Franchisor’s any website, WAP site, mobile application or Be Smart Citizen application. Or mail us at info@primehubsofttechsolutions.com for any amendment/suggestion.</p>
            <p>We make no warranty, express or implied, with respect to the Site, it’s Related Applications and Services offered or linked websites/application. We expressly disclaim the implied warranties of non-infringement, franchisee’s ability and fitness for any particular purpose. We provide the Site and Related Applications and any other technology or Services on the Site on an “as is”, “where is”, “with all faults” basis. We do not warrant that the Site or Related Applications, any products or Services shown or described on the Site or Related Applications, or other technology and services will be uninterrupted, error-free, available or operational at any particular time, or that any known defects will be corrected. We disclaim any liability for any information that may have become outdated since the last time the particular piece of information was updated. We reserve the right to make changes and corrections to any part of the content of this agreement/website at any time without prior notice.</p>
            <p>You expressly understand and agree that your use of the services is at your sole consent and that the Services are provided "as is" and "as available". In particular, Franchisor/Be Smart Citizen Wallet, its subsidiaries and affiliates, and its licensors do not represent or warrant to you that:
                You acknowledge that Franchisor is a facilitator for Mobile recharges and other Services and is not liable for any 3rd party products and services available on the Site and Be Smart Citizen Applications with respect to rates, quality, and all other instances. You expressly agree that use of the Services and the Site and Applications is at your sole consent and you shall not hold Franchisor liable for any discrepancy in third party products. It is your responsibility to evaluate the accuracy, completeness and usefulness in all opinions, advice, services, merchandise and other information provided through the site or on the internet generally.
            </p>
            <p>Any material downloaded or otherwise obtained through the use of the Service is done at your own discretion and consent that you will be solely responsible for any damage to your computer system or other devices or loss of data that results of downloading any such material. No advice or information whether oral or written, obtained by you from Franchisor or through or from the services shall create any warranty not expressly stated in the terms. Franchisor further expressly disclaims all warranties and conditions of any kind, whether expressed or implied, including, but not limited to the implied warranties and conditions of Merchant Franchisee ability, fitness for a particular purpose and non-infringement.</p>
            <p>You agree to indemnify, defend and hold Franchisor and/or related parties harmless from any and all claims, losses, damages, and liabilities, costs and expenses, including and without limitation, legal fees and expenses, arising out of or related to your use or misuse of the Franchisor, any violation of these Terms, or any breach of the representations, warranties, and covenants made by you.</p>
          </article>
                                            <br>
                                            <article>
            <div class="heading text-center">
              <h1>Facilitator Franchise Agreement</h1>
            </div>
            <br>
            <p>This Facilitator  Franchise  Agreement (The “Agreement”) is made/executed on date <input  type="text"  disabled="disabled" /> 
            at Jaipur, and the effectiveness of this Agreement is from the date of Joining of The Franchisee is on which he was after many discussions joined/Registered/
            from the date of use of any one service  with the Francshior’s T&C of this agreement  for this Franchisee by and between
            <b>Franchisor</b>, (hereinafter referred to as Franchisor) an IT software corporation having a place of business at <b>{{$globalData->address}}</b> 
            (hereinafter referred to as “Franchisor”, which expression shall unless repugnant to the subject or context mean and include its successors, permitted assigns, legal heirs and administrators), 
            of the <b>FIRST PARTY</b>, represented by <b>Mr. RAVI SHARMA ;</b></p>
            <p class="text-center"><b>AND</b></p>


            <p>Franchisee, an Individual firm / Company / Partnership Firm/ LLP etc. having its office at (hereinafter referred as second party represented by </p>
            <p><b>M/s </b> <b>{{$userdata->name}}</b>
            
            (<b>{{$userdata->aadhar_number}}</b>)  (“franchisee”)                                           </p>
            <p>       MEMBERID (<b>{{$userdata->agent_id}}</b>)                                                   </p>
            <p>                     (“Franchisee Type”), having a place of business at</p>
            <p class="col-md-6 txtbx"> <b>{{$userdata->address}}</b> </p>
           
            <p>,and being represented by its Director/ Proprietor Mr. <input  type="text"  disabled="disabled" />, hereinafter referred to as the “Franchisee” for State/ District/ Block / 
            Tehsil which expression shall, unless repugnant to the context or meaning thereof, be deemed to mean and include its successors and permitted assigns) and permitted assigns (as the case may be) of the <b>OTHER PART </b>   </p>
            <p>(Franchisor and       <input  type="text"  disabled="disabled" />                                         
            are hereinafter collectively referred to as the “Parties” and each of them is individually referred to as a “Party”).
            </p>
          <br><br>
          <b>WHEREAS</b>
          <ul>
            <li>   •	Franchisor is a limited company, and leading company in the field of Software and IT.  It provides various services like IT hardware and software services, web based services, design and creative, desktop based application, SEO services, toll free services, payment gateway services, security systems, money transfer, recharge, wallet and Merchant Franchisee etc.</li>
            <li>
              
              <b>AND THE FRANCHISEE</b>, after independently assessing market conditions and having satisfied himself about the viability of establishing a Business in affiliation with the Franchisor. And has approached to Franchisor with a request to establish the franchisee at the aforesaid place. The franchisee has represented to franchisor , that it is a specialized agency having adequate resources ,experience ,supervisory abilities and requisite statutory compliances to provide various services to support the sell/operations of franchisor ‘services through its own personnel as per the requirement of franchisor
            </li>
            <li>
              •	This agreement embodies the entire understanding of the parties with respect to the subject matter hereof, and merges all prior discussions between them, and neither of the parties shall be bound by any conditions, definitions, warranties, understandings and representations with respect to the subject matter hereof other than as expressly provided herein. No oral explanation or oral information by either party hereto shall alter the meaning or interpretation of this agreement.
            </li>
            <li>
              •	The parties have put their hands and seal voluntarily without any fear, pressure, force and caution through their authorized representatives and after having legal advice from their respective legal counsel and that the understanding recorded herein has been arrived at between the parties of their free volition and without any force, fraud or undue influence from any quarter.
            </li>
          </ul>
          <p><b>NOW, THEREFORE</b>, for and in consideration of the mutual promises, benefits and covenants contained herein and for other good and valuable consideration, The receipt, adequacy and sufficiency of which are hereby acknowledged, Franchisor and Franchisee, Intends to be legally bound, hereby agrees to the terms and conditions as detailed hereunder.
            In consideration of the mutual covenants contained in this agreement Franchisor and Franchisee.
          </p>
          <b class="underline">DEFINITIONS, INTERPRETATIONS AND PROJECT IMPLEMENTATION SERVICES</b>
          <br>
          <b class="shead"> [A] <span class="underline">DEFINITIONS</span></b> <br><br>
          <p><b>1)      Loaded Money</b> – A Loaded Money is that which Franchisor maintains in its electronic wallets for its source operator / supplier / service providers against each services and products.
          </p><p><b>
        2)     Service Delivery Mediums </b> - These are mediums available to deliver services to the customers by franchisor with the help of Franchisee. The service delivery mediums are as mentioned below; customer/franchisee is of liberty to choose the same as per their convenience. Below mentioned sub-clause details the mediums of service delivery.</p>
        <p><b>
          a)      API </b>- Application programming interface, It consist of a set of URL’s that connects with Franchisor's core application services that allow the creation of applications which access the features or data of an operating system, application or other services so as to make the transactions.
        </p>
        <p><b>
          b)      WEB portal</b> – Franchisor shall provide a unique username, password, PIN to Franchisee to login securely into the web based platform so as to execute any operation.
        </p>
        <p><b>
          c)       WAP </b>– Franchisor shall provide unique username, password, and PIN to login securely into the WAP sites so as to execute any operation.
        </p><p><b>
        d)      Desktop Application </b>– Franchisee shall download and install the desktop application. Franchisor shall provide a unique username, password and PIN to login so as to execute any operation.
      </p><p><b>
      e)      Mobile Application</b> – Franchisee should download and install the mobile application. Franchisor shall provide a unique username, password and PIN to login so as to execute any operation.
    </p><p><b>
    f)        Electronic Transaction</b> – Those transactions made via electronic mode by various operators / suppliers / service providers is known as electronic transaction.
  </p>
  <p><b>
    3)      Operators / Suppliers / Service Providers/Vendors/etc </b> – They provide varied services / products / connectivity to Franchisor so that Franchisor can further provide the same to its Franchisee in the mode of services and products that a franchisee demands. The suppliers / operators/service providers/vendors/etc  can be telecom operators / mobile operators / ISP / banks / payment banks / financial institutes / hotel & resorts / bus operators & owners / airline aggregators / airlines etc. products and services availed from the operator/supplier / service providers/vendors/etc  may vary / change from time to time.
  </p>
  <p><b>
    4)      Alert SMS  </b>– An SMS that is used to send communication / messages from the core application to the customers/franchisees.
  </p>
  <p><b>
    5)      Wallet  </b>– It is where the stocks purchased by the customers/franchisees are maintained and the same is maintained in Electronic Format.
  </p>
  <p><b>
    6)      Core Application Server / Software </b> - Franchisor's core application servers that host the integrated software/application to accelerate the operation and manage the Franchisee down line customers/franchisees.
  </p>
  <p><b>
    7)      Sales </b> - The process that details the purchase of any service/s by franchisee/customer after making appropriate payment to Franchisor, leads to sales.
  </p>
  <p><b>
    8)      Purchase </b> – A purchase shall become absolute only after any service is passed on to the customer/ Franchisee by Franchisor after the confirmation of payment.
  </p>
  <p><b>
    9)      Payments </b> – The amount that is transferred to the bank account of Franchisor in with the purchase of any service.
  </p>
  <p><b>
    10)  Products </b> – This refers to all the products and services which Franchisor provides / renders / sells or is providing / rendering / selling via this agreement. It can either be several different types of products or more than one of the same types of products or both.
  </p>
  <p><b>
    11)  Services </b>– The products or other services, provided by Franchisor as displayed in the updated version of Franchisor’s Website/App.
  </p>
  <p><b>
    12)  Billing/Invoice</b> –Credits, debits, dues, invoices or aggregate of all bills generated in a given period. It can either be system generated or personal issuance.
  </p>
  <p><b>
    13)  Receipt </b> – The issuance of a document either in electronic mode or printed format by Franchisor to its Franchisee acknowledging the sales of service payment made against any transaction.
  </p>
  <p><b>
    14)  Franchisee Marketing Materials </b> – Franchisee are not permitted to copy Franchisor’s marketing materials and shall promote Franchisor’s products ethically under their own brand contained/ but not with its own name and in accordance with this agreement unless otherwise stated in an addendum attached hereto operational contingencies. No one is allowed to use marketing material of Franchisor in a way that it is deemed to that particular Franchisee’s own brand or likewise. If Franchisee is found involved in breach of Intellectual Property Rights/ Confidentiality/ Data security obligations it shall be treated as willful default of Franchisee.  And he will be terminated immediately without prior notice and can proceed for necessary legal action and claim for loss in the  reputation of Franchisor by any type of advertising / publishing the article related to Franchisor  any products or services in the media . If, it is found that Franchisee has advertised or published any article without the knowledge of Franchisor, then in this case Franchisor will be entitled to claim liquidated damages and also shall to prosecute/terminated the franchisee, as may be decided by Franchisor.
  </p>
  <p><b>
    15)  Connectivity </b> - The word connectivity refers to programs / electronic equipment’s / device’s ability to link with other devices or programs and Franchisor requires connectivity from different operators and its suppliers for the completion of the execution of an operation.
  </p>
  <p><b>
    16)  User/Customer </b> – A User can be an individual / company / firm who pays to avail services and products of Franchisor from or via the Franchisee.  Availing of services or products may be direct or indirect depending on the plan the Franchisee opted.
  </p>
  <p><b>
    17)  Franchisee</b> – A Franchisee shall be an individual firm / company /partnership firm/LLP that purchases products or services from Franchisor with the intention to sell or provide services rather than consuming them. The reselling procedure is usually done for profit and a Franchisee is authorized to provide the same. A franchisee may be in the form of Retailer Franchisee, Digital Merchant Franchisee, DSO Franchisee, MDSO Franchisee(Master DSO franchisee) , Super DSO Franchisee(SDSO Franchisee)
    <OL>
        <li>
        <b>
        1)	Customer As Franchisee (CAF)    </b>– When a customer is working as franchisee he is called as CAF and he can be an individual / company / firm who pays to avail/sell services and products of Franchisor from or via the upline Franchisee. But CAF is bounded to certain number of services/products
      </li>
      <li>
        <b>
        Digital Merchant Franchisee </b>– an Individual firm / Company / Partnership Firm/LLP /etc. having its office that sells or provides products or services directly from upline Franchisee or directly from Franchisor.  The products and services are purchased by Digital Merchant Franchisee are sold to the end – user. Digital Merchant Franchisee have some limitation comparing to other upline franchisee  and DIGITAL MERCHANT is engaged in the business of marketing and distribution of Goods in India; and wishes to avail certain services from franchisor in order to offer Digital Payments in relation to the Goods& Services at his Outlet/Office.
      </li><li>
      <b>
      Retailer Franchisee </b> – An Individual firm / Company / Partnership Firm/LLP /etc. having its office which sells or provides products or services directly from upline Franchisee / or directly from Franchisor. The products and services are purchased by Retailer Franchisee are sold to the end – user.. Additionally Retailer franchisee can add  B2C/digital merchant franchisee in his downline
    </li><li>
    <b>
    DSO FRANCHISEE </b> – An Individual firm / Company / Partnership Firm / LLP / etc. having its office which sells or provides products or services directly from upline Franchisee / or directly from Franchisor. The products and services are purchased by Franchisee and are sold to the end – user. Additionally DSO franchisee can add retailer/digital merchant franchisee in his downline. He is having an area according to pin code demarcation system /defined structure of post office in India. It may be situated in Tehsils/Talukas/cities/districts or any state.
  </li><li>
  <b>
  MDSO FRANCHISEE </b> – MDSO FRANCHISEE is a Master DSO Franchisee. An Individual firm / Company / Partnership Firm / LLP / etc. having its office which sells or provides products or services directly from upline Franchisee /Franchisor. Product and services are purchased by Franchisee are sold to the end – user. Additionally MDSO franchisee can add digital merchant /retailer/DSO franchisee in his downline. MDSO FRANCHISEE is not having exclusive rights. Franchisor can appoint/ open more DSO FRANCHISEE/ MDSO FRANCHISEE in his/her area. 
</li><li>
<b>
SDSO FRANCHISEE  </b>– SDSO FRANCHISEE is a Super DSO Franchisee. An Individual firm / Company / Partnership Firm / LLP / etc. having its office which sells or provides products or services directly from upline Franchisee /Franchisor. Product and services are purchased by Franchisee are sold to the end – user. Additionally SDSO franchisee can add digital merchant /retailer/DSO/Mdso franchisee in his downline. SDSO FRANCHISEE is not having exclusive rights. Franchisor can appoint/ open more DSO/ MDSO/SDSO FRANCHISEE in his/her area. 
</li><li>
<b>
Sub Franchisee </b> – Any Upline franchisee having its downline will be considered its sub franchisee
</li><li>
<b>
White Labeled: </b> It is a software/application/cloud platform produced/developed by franchisor as producer/developer and after purchasing the product franchisee can rebrands it to appear as though they have made it by mentioning its own brand name. White labeled products are absolutely rebrand able to own brand
</li>
<li>
<b>
White Labeled Franchisee </b> It is a franchisee which works on the software/ application/cloud platform produced/developed by franchisor as producer/developer and after purchasing the product franchisee can rebrands it to appear as though they have made it by mentioning its own brand name. White labeled products are absolutely rebrand able as own brand of franchisee but on these products/services franchisor has no liability due to the customer/client/downline of white labeled franchisee. Any person linked with the network of white labeled franchisee, notwithstanding anything contained in this agreement can overcome the liability of this white labeled franchisee. <br />
All the T&C of this agreement is applicable on the white label franchisee. White label franchisee is able to use his name in all the service which is provided by {{$globalData->site_title}} to him. 
White label franchisee is only free to change/rebrand software on name as his own brand but other T&C of this agreement will be applicable on him as it is. Any advertisement or any steps related to the franchisor business must be pre approved by franchisor. White label franchisee is also bound by all guidelines of regulatory authority/authority of particular service 
</li>
<li>
<b>
Be Smart Citizen App: </b> A Mobile Application  which is developed by franchisor for the delivery of its products/services.
</li>
</OL>
</p>
<p> <b>
18)      Facilitator . Faciliatator ({{$globalData->site_title}}) is a Limited company which arranges facility from various Operators / Suppliers / Service Providers and provides to its franchisee  . it is a platform for many services/products for franchisee</b>
</p>
<p> <b>
19)  Third Party</b> – Third Party in this agreement shall be any individual / company/Firm who is not a direct party to this agreement made between Franchisor and the Franchisee and he may be the supplier/service provider/licensor of the service to franchisor.</p>
<p> <b>
20)  Server Uptime </b>– Franchisor ensures 99% uptime of its core application platform to its customers and expressly excludes scheduled downtime. The uptime calculation will be done on monthly basis and may very time to time.</p>
<p> <b>
21)  OTC (Non Refundable) </b> – One time charge is mutually agreed between Franchisee and Franchisor. The said One Time Charge (OTC) is applicable to all Business franchisees.</p>
<p> <b>
22)  AMC </b> - Annual Maintenance Cost is agreed between Franchisee and Franchisor. Franchisee shall pay an annual maintenance cost for availing the benefits of the entire platform.
</p>
<p> <b>
23)  Hosted Platform </b> – It is the cloud platform owned and managed by Franchisee where its core applications/ software are hosted.
</p>
<p> <b>
24)  Regulatory Authority </b>means and includes, without limitation Reserve bank of India (RBI), national payment corporation of India (NPCI) and any relevant government regulatory as well administrative bodies/authorities
</p>
<p>
25)<b>Reconciliation Report </b>:- It is the process used to compare two sets of records to ensure the transaction figures detailed in the record
 are accurate and also a key process to determine whether the two values are balanced at the end of every day of the recording period . 
 The days shall be set as acceptable for both the parties and may vary from services to services availed by the franchisee
</p>
 <p>
25)<b>QR Code </b>:- shall means Sticker used to accept digital payments virtually for lawful services/products (Not for illegal services/products)from anyone with the help of Credit/Debit Card, Net Banking, Wallet, Cash Card, IMPS, UPI Payment, Pre Credit Card etc… 
</p>
<b class="shead">[B] INTERPRETATION</b><br><br>
<p>
<b> 1. </b>   In construing this agreement, the singular shall include the plural and vice versa, and the neuter gender shall include the masculine or feminine gender (as the case may be), and vice versa.
</p>
<p>
<b> 2. </b>     Unless repugnant or contrary to the context hereof, the expressions herein, when capitalized, shall have the meanings assigned to such expressions in this agreement. When not capitalized, each word shall be given its ordinary meaning</p>
<p>
<b> 3. </b>       Any reference in this agreement to any statute or statutory provision shall be constructed as including a reference to that statute or statutory provision as from time to time amended, extended or re-enacted, annul, whether before or after the effective date of this agreement and to all statutory instruments, orders and regulations for the time being made pursuant to it or deriving validity from it.
</p>
<p>
<b> 4. </b>       Section headings are for convenience only, and shall not affect the construction of this agreement.
</p>
<p>
<b> 5. </b>      The recitals, annexure, schedules and appendices form part of this agreement and shall have the same force and effect as if expressly set out in the body of this agreement, and any reference to this agreement shall include any recitals, schedules and appendices to it. Any references to clauses and schedules are to clauses of and schedules to this agreement. Any references to parts or paragraphs are, unless otherwise stated, references to parts or paragraphs of the schedule in which the reference appears.
</p>
<p>
<b> 6. </b>      Any reference to a “person” includes any individual, firm, partnership, body corporate wherever incorporated or registered, corporation sole or aggregate, state or agency of a state, joint venture, partnership and any unincorporated association, in each case, whether having separate legal personality or not.
</p>
<br>
<b class="shead">[C] PROJECT IMPLEMENTATION SERVICES-
FRANCHISEE OBLIGATIONS
</b>
<br><br>
<b>Duties and Responsibilities of the Second Party (Franchisee)</b><br><br>
<p>
<b> 1. </b>    That Franchisee shall operate only those businesses with Franchisor's core platform that is or according to permissible by law in India. </p>
<p>
<b> 2. </b>     That Franchisee shall be of sole responsibility to maintain the unique username, password and PIN allotted to them and Franchisor shall not be held responsible for any misuse or misappropriation done with the same and update them time to time.
</p>
<p>
<b> 3. </b>     That Franchisee is of responsibility to provide flawless support to the down line franchisee so as to ensure that their business is on constant progression.
</p>
<p>
<b> 4. </b>      That the training under the scheme will be imparted as per the guidelines provided by the Franchisor in this regard.
</p>
<p>
<b> 5. </b>     That Franchisee shall plan and organize market development programs along with franchisor personnel and contacting local social help groups to promote products and connecting to customer/downline franchisee .
</p>
<p>
<b> 6. </b>      That if Franchisee appoints manpower to provide sales and service support to Digital Merchant Franchisee/ Retailer Franchisee/ DSO FRANCHISEE/ MDSO FRANCHISEE/ SUPER DSO FRANCHISEE , as required from time to time, as may be defined by the franchisor  then these manpower’s all responsibility related but not limited to salary, commission , remunerations is of Franchisee not Franchisor. Franchisor has no any employee employer connection with them. If Franchisee appoints manpower for the business growth then he cannot use them for any other purposes rather than promoting Franchisor’s services. The personnel so engaged by the franchisee shall have at no time any claim of employment with franchisor and shall not, for any purpose whatsoever, be considered employees or agents of franchisor. franchisee assumes full responsibility for the acts/omissions of its employee/personnel while performing services hereunder and shall be solely responsible for their compensation, benefits, salary, remuneration, wages, taxes, provident fund contributions and ESI contributions (as and when the same become applicable), bonus and any other dues whatsoever as may be payble(payable) by him as the empolyer/franchisee, under any law for the time being in force
</p>
<p>
<b> 7. </b>      That Franchisee will not run any type of business scheme related to this franchising without prior written permission of Franchisor and not give any advertisement to this regard.
</p>
<p>
<b> 8. </b>     That the Franchisee cannot take money for installation of Be Smart Citizen App or any other app in user mobile. If franchisee found involved in such type of activity, partnership( agreement ) will be canceled immediately without any intimation. The Franchisee cannot charge for any services that are free by Franchisor or cannot get extra charges from any one defined fix charge by the Franchisor.
</p>
<p>
<b> 9. </b>      That the Franchisee will have to strictly adhere to the norms, standards and guidelines laid down by the Franchisor on regular basis.
</p>
<p>
<b> 10. </b> That the Franchisee shall be liable to timely provide all the hard copies and soft copies records and documents to the Franchisor as desired with regard to the Scheme.
</p>
<p>
<b> 11. </b> That no fake commitment in any form to anyone shall be made by the franchisee. For more updated information franchisee should regularly visit on www.primehubsofttechsolutions.com , www.primehubsofttechsolutions.com, Be Smart Citizen App and your franchisee login and Franchisor group websites. All new terms and conditions are updated and shall be applied immediately. Franchisor will not be liable for any kind of commitments or promises made by the Franchisee to any person, be it a client or user associated with the Franchisee and/or other person acting in concert with the Franchisee.
</p>
<p>
<b> 12. </b> That Franchisee is of liberty to implement lawful business strategies to promote the platform / business to obtain more customers but he/she has to take written permission from top most authorities of Franchisor in advance before the implementation of the new business strategies at every implementing stage and it is important that these strategies are lawful made and according to the laws of India Unlawful actions are not permissible by the franchisor and he will cancel this agreement at any time
</p>
<p>
<b> 13. </b> Franchisee must not use the Services of franchisor to promote or operate any chain letters, Ponzi schemes, pyramid schemes, matrix programs, “get rich quick” schemes or similar letters, schemes or programs
</p>
<p>
<b> 14. </b> That Franchisee is not permitted to do any unlawful marketing communications and unsolicited commercial communications.
</p>
<p>
<b> 15. </b> That Franchisor may terminate this Agreement with immediate effect if the franchisee or it employees, agents or affiliates defames, abuses, harasses or threatens or otherwise compromises the dignity of the staff of the franchisor.
</p>
<p>
<b> 16. </b> That Franchisee shall not involve Franchisor in direct or indirect to execute the business strategies. Because Franchisor’s obligation is only to that extend to maintain the platform and to provide seamless connectivity as per the demand of the customer
</p>
<p>
<b> 17. </b>  That Franchisee shall be of sole responsibility on any profit / loss / arrears that may arise out of the business strategies implemented / executed.
</p>
<p>
<b> 18. </b> That during the term of this agreement and subject to these terms and conditions, No changes to the address as mentioned in the application/online apply form shall be permitted, except with the prior written consent from Franchisor where as such consent shall be signed by the authorized representative of Franchisor.
</p>
<p>
<b> 19. </b> That it is must for the  Franchisee he shall obtain all necessary license(s), permits and approvals for selling, distributing, marketing and promoting the services from the retail outlet and shall bear all costs and incidental expenses incurred in this regard, including without limitation all fees for application, license fees, charges and GST.
</p>
<p>
<b> 20. </b>  That it is necessary and must for the franchisee shall keep the Franchisee outlet/ offices kept open during normal business hours, or as permitted by law of local govt. / state govt. and govt. of India.
</p>
<p>
    <b>21</b> Franchisor wishes to appoint Franchisee for various geographical territories for the express purpose of identifying and appointing downline franchisee to establish a network for Franchisor in the assigned geography. Franchisee will train and support such Retailer Franchisee/Digital Merchant Franchisees such that the network delivers quality service to the customers by Franchisor and to other third party service providers aligned with Franchisor.
</p>
<p>
<b>22.</b>	The Franchisee shall ensure that the franchisee outlet is utilized for the purpose of rendering the services in accordance with these terms and conditions. The Franchisee shall further ensure that and shall not cause or permit (a) any material that may not be made available to the public under applicable law, including without limitation any vulgar, obscene, pornographic, misleading, defamatory, libelous, offensive, derogatory, threatening, harassing, abusive or violent content, to be made available in the franchisee outlet or (b) any activities that are proscribed under law or reasonably considered to be immoral or against public interest.
</p>
<p>
<b>23.</b>	Franchisor may, at its sole discretion and with or without consideration, provide training manuals, technology support, ongoing advice and assistance to the Franchisee and designated employees of franchisee, including provisions of brochures, pamphlets, charts, signboards, signage and other materials for the purposes of advertising, promotion and marketing of the services. Any materials supplied by Franchisor shall be utilized solely in relation to the provision of services and the Franchisee shall ensure that such materials are not utilized for any other purpose.
</p>
<p>
<b> 24.For commission:</b> The Franchisee shall(should) be regularly updated on the rates of commission through the franchisee  login of www.primehubsofttechsolutions.com and www.primehubsofttechsolutions.com. Franchisor, at its sole discretion shall decide the sharing of gross margin with the Franchisee and its decision will be final. It is presumed that the Franchisee has agreed to such commission / margin before the transaction. Any dispute in this regard will not be admissible by Franchisor further.
</p>
<p>
<b> 25.Prices and Discounts:</b> All prices, charges, fees and discounts for all Franchisor services shall be determined, and may vary from time to time or maybe revised by Franchisor at its sole discretion. The Franchisee shall not collect cash from the customers by offering discounts on the services which do not have Franchisor's sanction. The Franchisee shall also not provide any incentives, subsidies or do any act/ omission or thing, which shall have the effect of providing incentives or subsidies on the services. The Franchisee acknowledges that Franchisor has the right to alter the prices or nullify any sales/scheme that have been entered in the portal.
</p>
<p>
<b>
26.Taxes:</b> All current and/or future taxes or similar fees including without limitation GST, value added tax, service tax and other local or municipal taxes shall be payable by the Franchisee. Such amounts shall not be retained by the Franchisee while retaining its commission. Payments made to the Franchisee shall be subject to such withholdings as prescribed under applicable law. Subject to the aforesaid, Franchisor assumes no responsibility for the tax compliance of the Franchisee.
</p>
<p>
<b>
27.GST:</b> Franchisee shall be responsible to provide all required documentation and perform all necessary compliances under the GST Act so as to make Franchisor eligible to claim the input tax credit of GST. In case Franchisor is unable to claim the input tax credit due to the reasons including but not limited to, franchisee’s failure to declare the correct information regarding the invoice and tax paid and upload the same on GST portal, then the amount of tax pertaining to the GST paid by Franchisor shall be refunded by the Franchisee or the said amount shall be recovered from the franchisee, as the case may be.
<br><br>
<b>
“GST Act”: </b> means any Act imposing or relating to the imposition or administration of the tax levied by state or central government under State Goods & Services Act (SGST), Central Goods & Services Act (CGST), Integrated Goods & Services Act (IGST) and Union Territory Goods and Services Tax Act (UTGST) in India and regulations, rules made there under and as amended from time to time.
The charges payable as above will be subjected to the deduction of tax at source, wherever applicable, as per the provisions of the Income Tax Act, 1961 or any amendments thereto.
The charges payable as above and the terms and conditions as specified herein may be changed from time to time by Franchisor at its sole discretion and/or pursuant to the Applicable Law, without any reference to the Franchisee. The Franchisee will not be entitled to challenge the discretion of Franchisor in case of any change in the details aforesaid.
</p>
<p>
<b>
28.Costs:</b> All costs and expenses for operation of Franchisee office including but not limiting to electricity, telephone, staff salary, traveling, promotional activities and other similar out-of-pocket expenses incurred in the performance of the services shall be borne by the Franchisee.</p>
<p><b>
29. Set off:</b> Franchisor may, deduct or setoff sums due from the Franchisee under the terms and conditions of this agreement and the Franchisee hereby consents to such set off being made by Franchisor.
</p>
<p><b>
30.</b> That the Franchisee shall be solely responsible for dues and payments and legal formalities of all personnel employed, including payment of wages, making of contributions under various labor laws, such as the employees provident fund and miscellaneous provisions Act, 1952, the employees state insurance Act, 1948, etc.
</p>
<p><b>
31.</b> That the Franchisee acknowledges that it shall be responsible for all acts and omissions of its employees, subordinates, agents, aforesaid assignees or other personnel engaged by the Franchisee.
</p>
<p><b>
32.</b>That the Franchisee will fully devote the time towards its duties & responsibilities and will work diligently.
</p>
<p><b>
33.</b>That the Franchisee shall not share data/information with any third party except in the cases where he is duly authorized by the Franchisor in writing. Be aware about our privacy policy www.primehubsofttechsolutions.com
</p>
<p>
<b>
34.</b>That the Franchisee shall not pledge the Franchisor credit and/or make representation from his side unless the Franchisor is specifically and duly authorized him on his behalf.
</p>
<p>
<b>
35.</b>The Franchisee may describe himself as an 'authorized  Retailer Franchisee/Digital Merchant Franchisee / DSO FRANCHISEE/ MDSO FRANCHISEE/ SUPER DSO FRANCHISEE/  of Franchisor with  the consent/authorization of the Franchisor, but must not hold [itself/himself] out as being entitled to bind Franchisor in any way. The Franchisee shall not make, cause or permit, directly or indirectly, any description or projection of itself as a partner or employee or officer or representative of Franchisor.
</p>
<p>
<b>
36.</b> The Franchisee has understood the business model and is aware that Franchisor is just a facilitator of products and services and does not own such services or products by itself. Franchisor takes reasonable efforts to make available(availability of) the services and products, however, shall not be liable and responsible for any deficiency of such services and products. Franchisor further also takes reasonable efforts to provide its best uninterrupted services at best quality; however, technological systems are prone to interruption for up gradation, maintenance, breaks down of either the systems of Franchisor or that of the Service Providers’. The Franchisee shall be managing his business considering such interruptions.
</p>
<p><b>
37.</b>During the term, The Franchisee shall render the services (“Services”) of Franchisor, by and through such of its officers, employees, agents, representatives and affiliates as it shall designate, from time to time. Notwithstanding anything contrary contained in these terms and conditions, Franchisor shall have the right at any time, to modify, alter and amend the lists of services, including the manner, procedure, process in which The Franchisee will be required to perform the services and The Franchisee shall be bound by all such modifications, alterations and amendments made by Franchisor.
</p>
<p><b>
38.</b>All Services shall be provided solely through the portals of Franchisor or are recorded therein and no offline transactions are permitted and/or no such fake/false receipts should be issued by the Franchisee for the willful fraud transaction done by the Franchisee which is not transacted through Franchisor Software/Portals. However, if any  Retailer Franchisee/Digital Merchant Franchisee / DSO FRANCHISEE/ MDSO FRANCHISEE/ SUPER DSO FRANCHISEE  is found and/or discovered doing any such malicious/wrong/willful/fraudulent acts and/or offline transactions, it shall be liable and charged for such civil/penal and criminal acts by and under but not limited to the Indian Penal Code 1860 and Criminal Procedure Code 1973.
</p>
<p><b>
39.</b>That the Franchisee will abide by the rules & regulations / standing orders of the organization in force, at present, and as varied from time to time.
</p>
<br>
<b >
FRANCHISOR OBLIGATIONS
</b> 
<br><b>
Duties and Responsibilities of the Franchisor
</b>
<p>
1.     In accordance with the demand of the customer, Franchisor purchases services from different service providers / suppliers / operators and makes it available to use it in the software in the modus of wallet.
</p><p>
2.     Franchisor shall provide hosted service, which is vital for the effortless and efficient functioning of the entire business managed by the Franchisee/s.
</p><p>
3.     Franchisor shall make available to the Franchisee the following:
<ul>
<li> a)     Standard plans, specifications, processes and product guidelines for on boarding, servicing and support of the Retailer Franchisee/Digital Merchant Franchisees and for market development.  </li>
<li>  b)     Such assistance as Franchisor determines is required in connection with the activities as franchisee, including assistance by way of planning and reviewing the business operations in order to help in achieving business goals. </li>
<li> c)      Initial training about the system, including standards, methods, procedure and techniques, at such times and places as Franchisor may, in its discretion, designate for the purpose.
</li>
<li>  d)     The use of literature, brochures and basic technical data and training aids as revised by Franchisor from time to time; via online on website or any other means .
</li>
<li>e)     Such marketing materials, other data and advices as may, from time to time, be developed by Franchisor and demanded by franchisee to be helpful in the operation of the franchisee.
</li>
<li>
f)       Such periodic, individual or groups, advices, consultation and assistance rendered by personal visits or on phone or by letters or bulletins made available, from time to time, as Franchisor may deem necessary or appropriate;
</li>
</ul>
</p><p>
4.     Franchisor shall provide technical support through telephone/email/tickets from 9.30 am to 6.30 pm from Monday – Saturday. Except holidays
</p><p>
5.     Franchisor shall  provide designs soft copy of promotional material to be used by the Second Party and the Retailer Franchisee/Digital Merchant Franchisee /DSO/MDSO/SDSO Franchisee for promoting enrollments in the scheme.
</p><p>
Franchisee and Franchisor, agree that the Franchisee shall be responsible for their own individual obligations, if any, to obtain any and all consents and approvals that are required from regulatory or governmental authorities, as the case may be, in accordance with applicable data protection Laws, if any.
It is acknowledged and understood that Franchisor shall not be responsible for settling third party disputes that arise out of the provisions of franchisee’s services under this Agreement including disputes between the Franchisee and Outlets of the Retailer Franchisee/Digital Merchant Franchisee / down line. If <b> any disputes arise in transaction due to any technical errors from Franchisor’s side then Franchisor will be solely responsible for resolving such dispute.</b>
</p>
<br><br>
<b class="underline">
SPECIAL POINT (T&C) SHOULD BE KEPT IN MIND EVERY TIME BY FRANCHISEE
</b>
<br>
<b class="shead" ><span class="underline">
[D] BE AWARE</span>
</b>
<br><br>
<b>Please ensure the following before logging in:</b>
<ul>
<li>
Always check for the correct URL address For {{$globalData->site_title}} Money Transfer service (www.primehubsofttechsolutions.com, www.primehubsofttechsolutions.com )
</li>
<li>
Do not enter login or other sensitive information to any other website except listed the above one.
</li>
<li>
Please always change/reset your password periodically
</li>
<li>  Keep checking your registered email. Our schemes are always sent through email circulars or on our website www.primehubsofttechsolutions.com, www.primehubsofttechsolutions.com </li>
<li>  Do not share your ID and password with anyone. </li>
</ul>
<br>
<b> Beware of Phishing Attacks </b><br><br>
<ul>
<li>
Phishing is a fraudulent attempt, usually made through social media sites like face book, email, phone calls, SMS etc seeking your personal and confidential information.
</li>
<li>
Never respond to such face book post/web address/email/SMS or phone call. Please report immediately at info@primehubsofttechsolutions.com
</li>
<li>
Some websites have created similar design and template as ours, please check the URL address <a href="#"> www.primehubsofttechsolutions.com</a>, <a href="#">www.{{$globalData->site_title}}soft. in</a> before you put your username and password.
</li>
</ul>
<br>
<b class="shead"> [E] <span class="underline">SPECIAL POINTS </span></b><br><br>
<ul>
<li>  OTC is non refundable and non transferable under any circumstances after depositing the amount for Digital Merchant Franchisee, Retailer Franchisee, DSO FRANCHISEE, MDSO FRANCHISEE, SUPER DSO FRANCHISEE.
</li>
<li>  Transaction shall be done for once only. If it found failed do not try again. We are not responsible of any mistake. </li>
<li>  Fees defended by Franchisor along with GST must be collected fully in advance. No credit limit in any condition or no part payment would be done. If you make any order whether by mistake or otherwise Franchisor will debit your account in reasonable time. </li>
<li> All new schemes/ plans have respective additional terms and conditions should be read carefully before implementation or working on new schemes/ plans. </li>
<li>  If any new guideline/rule issued by RBI, NPCI, Bank, our suppliers/licensors same will be imposed on Franchisee without any intimation.  </li>
<li> Fee is non-refundable, non transferable and non adjustable under any circumstances.  </li>
<li>  If any type of fake currency as well as fraud(fraudulent) activity is found on any Retailer Franchisee/ Digital Merchant Franchisee/Any type of Franchisee counter it will not be a responsibility of Franchisor. Franchisees are advised to be aware about such activities. </li>
<li>  Cannot take more fees from sub franchisee or  customer  as decided by franchisor on particular date if found, account will be terminated immediately and total commission will be forfeited and violation of cash collection on name of Franchisor. Franchisor will take legal action by filing FIR in Police station and other legal proceedings. </li>
<li>   If you join as a DSO FRANCHISEE/MDSO franchisee /SUPER DSO FRANCHISEE and you will not achieve your given targets and not reach at village level then we shall terminate you and you shall not be eligible for any refund. </li>
<li>  If any Employee/ FSA-Field sales associates/ FSO - Field sales officer / franchisee makes any commitment then don’t believe and you should take only written information from Franchisor via letter head or info@primehubsofttechsolutions.com, and not any other media. </li>
<li> We are authorized by third party/suppliers/licensors/service providers for different services . If third party changes their rule regulation/Term and condition same will be applied without any prior information. Commission and fee structure may change at any point of time without prior info. Except from website and software we are providing consultancy for some  more services thus the Terms&conditions/rule&regulations will be applicable in the same as they are  </li>
<li> The Franchisee will ensure that they will not call a person whose name/number is flagged in any "do not disturb" list. </li>
<li>  Telephonic contact will normally be limited between 09:30 Hrs and 18:30 Hrs. However, the Franchisee will ensure that a customer is contacted only when the call is not expected to inconvenience to him / her.
</li>
<li>  Calls earlier or later than the prescribed time period may be placed only when the customer has expressly authorized you to do so either in writing or orally </li>
<li>  The Franchisee will make sure that a customer’s privacy is respected. </li>
<li>No serial dialing will be made.  </li>
<li> If denied permission, he/she will apologize and politely disconnected. </li>
<li> The Franchisee establishment will provide feedback to the Company on customers who have expressed their desire to be flagged "Do Not Disturb". </li>
<li> Provide his/her telephone number, and the supervisor's name or the concerned company officer's contact details, if asked for by the customer.
</li>
<li>  Limit discussions with the customer to the business. Maintain a professional distance. </li>
<li>  You have all original software hardware with valid license it is your responsibility to maintain and update all software and hardware. </li>
<li> If you and your organization is found involved in any illegal activity, currently or in future or any FIR against you or on your organization, we will suspend your account immediately without any info and discussion. </li>
</ul>
<br>
<b>  Duties of Franchisee</b><br><br>
<ul>
<li> Identify prospective of sub franchisee/customer </li>
<li>  sub franchisee’s profile check </li>
<li> Explain the concept, sell the services or  products to sub franchisee/customer </li>
<li> First hand support on(to) sub franchisee/customer for service problems. Connect with the company to resolve them. </li>
<li>Ensuring brand visibility and implementation of branding plans.  </li>
<li> Training of sub franchisee </li>
<li> Field service support. </li>
<li> Planning and organizing market development programs  in the field for the development of network. </li>
<li> Contacting local social help groups to promote products and connecting to sub partners(franchisees). </li>
</ul>
<br>
<b class="shead">  [F]<span class="underline"> INTELLECTUAL PROPERTY</span></b>

<br>
<p>
<b> 1. </b>  No license under any patents, copyrights, trademarks or any other intellectual property rights of Franchisor / its affiliates / its Service Provider(s) / third party(ies) is granted to or conferred upon to the Franchisee by virtue of being the Franchisee of Franchisor. The Franchisee shall not acquire any interest and right on the trademark(s), trade name(s), logo, etc. of other party including Franchisor by virtue of this agreement and shall not use the logos, trademark of Franchisor/owner of intellectual property on including interlaid unless permitted in written by signatory authorities of franchisor .
</p> <p>
<b> 2. </b>      The Franchisee agrees to protect the logo, trade name and trademark of Franchisor and not use the same, in any unauthorized manner, whatsoever, including interlaid as a tool for acknowledging payments accepted by the Franchisee/his representative, thereby creating false impression about the authenticity of such acknowledgment / receipt. The Franchisee hereby undertakes to indemnify, defend and hold Franchisor harmless for all loss (es) / damage(s) arising due to infringement of this clause.
</p> <p>
<b> 3. </b>      The Franchisee is aware of the consequences. If at all, The Franchisee and/or his representative are found in unauthorized use of Franchisor logo/ trade name(s) in any manner, then strict action shall be taken against the Franchisee, including permanent deactivation of his services, but not limited to any other legal action which Franchisor may deem fit and proper, under the provisions of law.
</p> <p>
<b> 4. </b>      Each party of this network shall retain all right, title and interest in the intellectual property rights in its intellectual property. No interest whatsoever in the other party’s intellectual property rights is granted by this agreement and use of any Intellectual Property right vested in one Party by the other Party shall be strictly in terms of this agreement. The Parties shall not license, sell, publish, disclose, display or otherwise make available the Intellectual Property of the other Party to any person or entity except as provided in this agreement. Either Party may include security modules in their Intellectual Property products (as defined hereunder) to protect their rights. All writings and works of authorship relating to the Intellectual Property created by either Party (including but not limited to software, source code, blueprints, diagrams, flow charts, modifications, enhancements or changes made by such Party to any of its Intellectual Property) shall be owned by that respective Party. To the fullest extent permissible by applicable laws, both Parties agree that they will not, nor will they allow others to, reverse engineer or disassemble any parts of the other party's Intellectual Property Products.
</p> <p>
<b> 5. </b>     All software including all translation, modification, adaptation or derivation of the same provided or created by FRANCHISOR and all systems and data-bases provided hereunder by FRANCHISOR to Franchisee in connection with the services or products, and all new modules or services, copies, enhancements, improvements, new versions or updates associated therewith (collectively, the "FRANCHISOR Products"), are FRANCHISOR's exclusive property and all right, title and interest therein remains in FRANCHISOR. All software programs and documentation with respect to FRANCHISOR products are copyrighted and/or patented by FRANCHISOR. All software including all translation, modification, adaptation or derivation of the same provided or created by Franchisee and all systems and data-bases provided hereunder by Franchisee to FRANCHISOR in connection with the services or products, and all new modules or services, copies, enhancements, improvements, new versions or updates associated therewith (collectively, the " Franchisee’s Products"), are FRANCHISOR‘s exclusive property and all right, title and interest therein remains in Franchisee. The FRANCHISOR’s Products and the Franchisee’s products are hereinafter collectively referred to as the "Intellectual Property Products".
</p> <p>
<b> 6. </b>      Neither party shall alter, remove or conceal any copyright, trade secret or other proprietary rights or notices that may appear on or within the other party's intellectual property products or related documentation. Both the parties shall reproduce such notices of the other party's rights on any copies of the other party's intellectual property products and any user documentation created by such party.
</p> <p>
<b> 7. </b>     Except as expressly permitted above, franchisee agree not to sub-license, license, rent, sell, loan, give or otherwise distribute all or any part of the intellectual property products of the other party to any third party.
</p>
<br>
<b class="shead"> [G]<span class="underline">  CONFIDENTIALITY & NON - DISCLOSURE</span></b>

<br>
<p>
1.     This clause contains the entire understanding of the parties hereto with respect to the Confidentiality & Non- Disclosure terms and matters contemplated hereby, Franchisor and Franchisee agree not to disclose any of the confidential details to any other person, public, company or third party (unless/until required by law) or use for any personal gain, at any time during or after the term of this agreement, unless customer grants express, written consent of such a disclosure. In addition, FRANCHISOR may use its best efforts to prevent any such disclosure but only to that extent which shall be possible.
</p><p>
2.     The Franchisee agrees that all information disclosed by Franchisor or which the Franchisee gets in the course of negotiating this agreement is confidential in nature and hence cannot be disclosed. Each Party may disclose the existence of this agreement, but agrees that the terms and conditions of this agreement will be treated as confidential information; provided, however, that each Party may disclose the terms and conditions of this agreement: (a) as required by any court or other governmental body; (b) as otherwise required by law; (c) to legal counsel of the parties; (d) in confidence, to accountants, banks, and financing sources and their Advisor Franchisees; (e) in connection with the enforcement of this agreement or rights under this agreement; or (f) in confidence, in connection with an actual or proposed merger, acquisition or similar transaction.
</p><p>
3.     The Franchisee also agrees that on and from the date of this agreement all information, which Franchisee may obtain from Franchisor pursuant to this agreement, shall be kept confidential by Franchisee and shall not be disclosed to any third party, save and except with the prior written consent of the Franchisor.
</p><p>
4.     In addition to all data that is marked as confidential, all customer related data and information, proprietary data and databases, all trade secrets, know how licenses, know how formulas and processes shall be deemed to be confidential for the purposes of this agreement.
</p><p>
5.     Each of the parties agree that it will keep confidential all data provided by other party and resultant data generated by the Franchisee relating to the performance of its services under this agreement and will not use it for any purpose other than to perform its obligations under this agreement. Both the parties shall keep it confidential and use only for purposes of this agreement:  (i) all information communicated to it by Franchisor or Franchisee whether before or after the effective date; (ii) all data that is confidential to which it has access in connection with the services, whether before or after the effective date; and (iii) this agreement and the Parties' rights and obligations under this agreement. Each party shall use the same means as it uses to protect its own confidential information, but in no event less than reasonable means, to prevent the disclosure and to protect the confidentiality thereof.  Neither Party shall divulge information concerning the project, information about the customer(s) or the terms and conditions of this agreement to anyone (including a local authority in an application for any permission or approval) without the other’s prior written consent, and such consent shall not be unreasonably withheld
</p><p>
6.     Each type of franchisee shall be under an obligation to not share the source code provided by Franchisor to any third party under any circumstance.
</p><p>
7.     Franchisee also binds by our privacy policy when interacting with customer and Franchisor.  www.primehubsofttechsolutions.com
</p>
<br>
<b class="shead">[H]<span class="underline">  SECURITY OF CONFIDENTIAL USER INFORMATION</span></b>

<br>
<p>
<b>1.     Security of User ID and Password: </b>The Franchisee shall solely, exclusively and absolutely responsible and liable for safeguarding and/or securing the confidentiality of the user id and passwords relating to access of Franchisor Services and such other relevant information, in whatsoever name called pertaining to The Franchisee/User Account of The Franchisee.
</p><p><b>
2.     Unauthorized Access: </b>The Franchisee shall take all necessary precautions to prevent unauthorized or illegal use of Franchisor’s services and unauthorized access to the Franchisee accounts provided by Franchisor. The Franchisee hereby agrees that Franchisor shall not be held liable and/or responsible for any wrongdoings/ misappropriation/ misrepresentation/any leakage of passwords and for any liability arising due to insufficient security maintained by The Franchisee with respect to the Franchisee account .  Franchisor shall take all commercially viable and/or reasonable care to, ensure the security of and to prevent unauthorized access, using commercially viable and reasonable technology available to Franchisor.
</p><p> <b>
3.     Fraud/fake transactions:</b> Franchisor shall not be liable and/or responsible for any fraud/fake transactions occurring from The Franchisee by any third party. Franchisor takes utmost care for encryption of any type of franchisee personal details. However, Franchisor cannot control the misuse of the sensitive information like passwords once it is handed over to the franchisee. Franchisee shall be responsible to follow standard guidelines for securing their id/password for the Franchisor Software.
</p>
<br>
<b class="shead">[I]<span class="underline">  EXCLUSIVITY AND ACTIVE FRANCHISEE DEFINITION</span></b>

<br>
<p> 1.     This Agreement will be on a Non - Exclusivity basis. </p>
<p> 2.     During the continuation term of this agreement, The Franchisee shall not, directly or indirectly, through any other person, firm, corporation or other entity (whether as an officer, director, employee, partner, consultant, and holder of equity or debt investment, lender or in any other manner or capacity): (a) market, offer and/or perform services similar to that being developed, offered or sold by Franchisor; (b)solicit, induce, encourage or attempt to induce or encourage any employee or consultant of Franchisor to terminate his or her employment or consulting relationship with Franchisor, or to breach any other obligation to Franchisor; (c) solicit, interfere with, disrupt, alter or attempt to disrupt or alter the relationship, contractual or otherwise, between Franchisor and any other person including, without limitation, any consultant, contractor, customer, potential customer, or supplier of Franchisor; or (d) engage in or participate in any business conducted under any name that shall be the same as or similar to the name of Franchisor or any trade name used by Franchisor. </p>
<p> 3.     If you will not work properly and are not able to achieve the given target time to time  then we may/shall appoint  new franchisee or promote down line franchisee without any prior notice or information, it’s depends on your 3 months continuous work performance. So you should be always active for  business by yourself.
</p>
<p> 4.     If any other franchisee appoints a Retailer Franchisee/Digital Merchant Franchisee or DSO FRANCHISEE in your area then share of that franchisee will not be shared with you.
</p>
<br>
<b class="shead">[J]<span class="underline">  WARRANTIES AND COVENANTS OF THE FRANCHISEE</span></b>

<br>
<p> 1.     The Franchisee hereby warrants, covenants and undertakes that it shall (a) promptly, effectively, efficiently and professionally sell, market, distribute and promote the services and shall promptly respond to all inquiries by any customer or potential customer in relation to the services; (b) at all times co-operate with Franchisor's representative(s) and promptly report to Franchisor any complaints or customer feedback relating to the services which may come to The Franchisee's attention; (c) conduct its operations in compliance with applicable law, these terms and conditions and all guidelines and instructions that may be provided by Franchisor from time to time; (d) promote Franchisor's business interests; (e) not do or omit, or cause to be done or omitted, any act, deed or thing, directly or indirectly which may potentially result in any damage to, loss of reputation of or any loss to Franchisor in any manner whatsoever; (f) employ sufficient number of personnel to provide the services, who shall be adequately trained to provide the Services; (g) ensure all personnel employed by its comply with these terms and conditions and The Franchisee shall be solely responsible for all acts/omissions of such personnel; (h) not enter into any agreements with customers or any other third parties which are contrary to law or to these terms and conditions; (i) adhere to and shall cause its employees, subordinates, agents, aforesaid assignees or other personnel engaged by The Franchisee to provide the services to adhere to the dress code and professional conduct and etiquette as prescribed by Franchisor from time to time; (j) ensure that none of the services are denied to any person or group of persons or to any customer save and except with the express written consent and / or instructions of Franchisor; (k) not engage in any unfair or unethical trade or practice; (l) not permit unauthorized persons entry into the retail outlet and shall, under no circumstance, permit any unauthorized person to access the computer/server located at the retail outlet or access to information, material, accounts and records in relation to Franchisor Services; (m) not permit any other person whosoever, to conduct any business, trade or profession of any nature at the Retail Outlet; and (n) obtain and maintain all required necessary approvals, permits, waivers, consents, registrations and licenses from the relevant authority to perform all its obligations under these terms and conditions.
</p>
<p>
2.     The Franchisee agrees that he shall be solely liable and responsible for any seizure of instruments provided by Franchisor to it by any governmental authority for its actual or alleged illegal unlawful act.
</p>
<p> 3.     The Franchisee shall be solely responsible for creating its outlets / customer for down line customers / down line Sub Franchisee/ Retailer Franchisee/Digital Merchant Franchisee / MDSO FRANCHISEE/ DSO FRANCHISEE/ SUPER DSO FRANCHISEE and acquiring subscribers for selling the Products and Services.
</p>
<p> 4.     The Franchisee agrees that it shall be solely liable and responsible for taking any type of insurance including but not limited to cash handling/transit Insurance, in accordance to provide protection to Franchisor business accordingly from time to time.
</p>
<p> 5.     The Franchisee agrees and undertakes to ensure that the contact details including phone number and/or any other credentials of the consumer/s which needs to be captured on Franchisor platform for acknowledging the transaction done at Franchisor network, should be genuinely of the customer and/or taken from the customer/s and The Franchisee shall not put his own or any fake / wrong credentials on behalf of customer(s), in any manner whatsoever. Also bind by our privacy policy www.primehubsofttechsolutions.com
</p>
<p> 6.     The Franchisee also agrees that it shall during the term of this agreement, allow Franchisor and/or any other statutory authority/ person of its management, auditors, regulators and/or agents the opportunity of inspecting, examining, auditing and/or taking copies of any records with The Franchisee in relation to the performance of the services by Franchisee.
</p>
<p>7.     The Franchisee shall cooperate with such internal or external auditors and/or as defined above to assure a prompt and accurate audit of The Franchisee’s records and data and shall also cooperate in good faith and in best efforts basis with Franchisor to correct any practices, which are found to be deficient as a result of any such audit within a reasonable time.
</p>
<p> 8.     The Franchisee shall perform its responsibilities under these terms and conditions diligently and shall strive to increase the sale of Franchisor Services to the best of its ability and shall always maintain a good relationship with the specified Franchisee and the customers and shall maintain total transparency in relation to the same.
</p>
<br>
<b class="shead">[K]<span class="underline">  CHANGE IN RETAILER FRANCHISEE/DIGITAL MERCHANT FRANCHISEE / MDSO FRANCHISEE/ DSO FRANCHISEE/ SUPER DSO FRANCHISEE</span></b>

<br>
<p> 1.     If The Franchisee is an individual, in the event of his/her death, incapacity or inability to operate the Retail Outlet, his/her successor or assignee shall continue to operate the Retail Outlet only after obtaining a prior written consent from Franchisor. </p>
<p> 2.     If The Franchisee is a partnership or a company, in the event of a change in control of the partnership or company, due to a change in the partnership or change in management or majority shareholding of the company, as the case may be, the successors in interest or permitted assigns of the partnership or the company, as the case, may continue to operate the Retail Outlet only after obtaining
</p>
<br>
<b class="shead">[L]<span class="underline"> REPRESENTATIONS AND WARRANTIES</span></b>

<br>
<p> 1.     The Franchisee represents and warrants that: (a) it has had a full and adequate opportunity to read and review this agreement and to be thoroughly advised of the terms and conditions of this agreement by an attorney or other personal representative, and has had sufficient time to evaluate and investigate the provision of services under this agreement and the financial requirements and risks associated with the same; (b) Neither the execution of this agreement nor the performance of The Franchisee's obligations under this agreement will result in a violation or breach of any other agreement by which The Franchisee is bound; (c) it has and will continue to have the power and authority to be bound by these terms and conditions and to perform and fulfill all activities contemplated herein and that no other person or entity is required to consent or provide permission to the activities contemplated under these terms and conditions and The Franchisee is not subject to any agreement, judgment or order inconsistent with these terms and conditions; (d) the entry into and performance of these terms and conditions in accordance therewith shall not result in a violation of applicable law, its charter documents or any other agreement by which it is bound; and (e) it is adequately insured for all liabilities specified herein. </p>
<p>  2.     The warranties provided herein by The Franchisee are in addition to and do not exclude any of the implied warranties under the applicable law with respect to the activities contemplated under these terms and conditions.
</p>
<p>  3.     It is explicitly understood that The Franchisee shall have complete control over the outlets / Customers of Down line Franchisee / down line Retailer Franchisee/Digital Merchant Franchisee s and subscribers and that Franchisor will not be responsible to entertain any complaints / queries received from the Franchisee’s outlets/office/subscribers. The Franchisee shall act as the one-point contact for all its outlets/subscribers and shall be solely responsible for any fraudulent acts of its outlets/office. Franchisor will however provide backend support for any and all complaints/ issues/concerns/ queries to direct franchisee’s staff during their operation time.
</p>
<p> 4.     Franchisor shall warrant and represent that all content that is uploaded or made available to Franchisee shall not be unlawful, misleading, factually incorrect, or violating any right including proprietary rights of any person or entity.
</p>
<p>  5.     Franchisee and Franchisor, agree that the Franchisee shall be responsible for their own individual obligations, if any, to obtain any and all consents and approvals that/those are required governmental from regulatory or authorities, as the case may be, in accordance with applicable data protection Laws, if any.
</p>
<p> 6.     The Franchisee has obtained all regulatory approvals / licenses to enter into this agreement if necessarily needed to begin and continue the service. Franchisee shall bring to the notice of the franchisor  of any expiry, material modification, or licenses or the initiation of any adverse action by the relevant authority concerned, that may prevent/ restrict it from honoring this agreement.
</p>
<p> 7.     The Franchisee warrants to Franchisor that  Franchisee  is:
<ul class="list-unstyled">
<li> a.       Capable of undertaking activities as agreed herein.  </li>
<li> b.      Not prohibited from performing activities agreed in this agreement whether due to any legal, statutory, judicial orders or any contractual obligations.  </li>
<li> c.       Not undertaking any activity during the tenure of this agreement which is infringing intellectual property rights of any third party And Franchisor.  </li>
<li>
d.      Not undertaking any action or franchisee’s inaction is not causing violation of any laws and regulations or breach of any other statutory binding as may be applicable. </li>
<li>   e.       Not undertaking any activity which is competing with the business of Franchisor.
</li>
</ul>
</p>
<br>
<b class="shead">[M].<span class="underline"> INDEMNITY</span></b>

<br>
<p> 1.     The Franchisee hereby undertakes to indemnify, defend and hold harmless Franchisor, its affiliates, officers, directors, employees, agents, successors and assignees (collectively the “Indemnified Parties”) from and against all claims, damages (special or consequential), losses and expenses, including court costs and reasonable fees and expenses of attorneys, expert witnesses and other professionals, arising out of or resulting from: (a) any action by a(the) third party against the Indemnified Parties that is based on any negligent act, material omission or willful misconduct of the Franchisee or its employees, personnel, officers or agents and which results in: (i) any bodily injury, sickness, disease or death; (ii) any injury or destruction to tangible or intangible property (including computer programs and data) or any loss of use resulting thereof; or, (iii) any violation of any statute, ordinance, or regulation; (b) any loss, damage or prejudice suffered by any of the Indemnified Parties due to the breach by The Franchisee of(under) any applicable laws, by-laws, regulations and guidelines; (c) any loss, damage or prejudice suffered by any of the Indemnified Parties due to The Franchisee representing/providing wrong information to third parties in an unauthorized manner on behalf of Franchisor; (d) any loss, damage or prejudice suffered by reason of any claim or proceeding by any third party against any of the Indemnified Parties due to the infringement of Franchisor Intellectual Property by the Franchisee during the provision of the Services; (e) any loss, damage or prejudice suffered by any of the Indemnified Parties due to any claim made by  the Franchisee's employees against Franchisor for non compliance with any labor laws; and (f) any misrepresentation of any representation or warranty of The Franchisee under these Terms and Conditions.
</p>
<p> 2.     Any loss arising out of any fraudulent electronic transactions shall be the sole responsibility of the Franchisee. </p>
<p>3.	If any proceedings be undertaken which may give rise to franchisor’s liability under this Agreement, franchisee shall provide to franchisor with prompt notice and an opportunity to participate in any such proceedings to represent its interest appropriately.</p>
<p> 4.	The Franchisee agrees that notwithstanding anything contained in this agreement , the aggregate liability of franchisor to the franchisee or any of them , for any action done, or omitted to be done under or pursuant to the terms and conditions of this agreement or for any breach of any covenant or in tort , shall at all times be limited to INR 1000(rupees one thousand only) provided however that franchisor shall not be liable for any indirect or consequential loss or damage, or special or punitive or exemplary damages , or loss of profit , business ,revenue ,goodwill or anticipated savings to the franchisee , franchisor shall also not be liable for  any liability , losses, damages ,cost, expenses ,(including legal fees, court fees and professional fees), suits and claims that are finally judicially determined to have resulted primarily from the negligence or infringing action of the client/customer of franchise or any other person
</p>
<br>
<b class="shead"> [N] <span class="underline"> DEFAULT AND TERMINATION</span></b>

<br>
<p>1.     This agreement may be terminated by either party by giving one month's notice in writing to the other, without assigning any reason whatsoever. In such cases the down line members if any, will still be associated with Franchisor.   </p>
<p> 2.     Franchisor shall be entitled to terminate the appointment of The Franchisee by written notice of Thirty days or without notice in the following circumstances:
<ul class="list-unstyled">
<li> a)       The Franchisee commits any breach of any of the provisions of these terms and conditions and, in the case of a breach capable of remedy, fails to remedy the same within 15 days after receipt of a written notice giving particulars of the breach and requiring it to be remedied.  </li>
<li> b)      The Franchise at any time breaches any obligation in relation to Franchisor Intellectual Property.  </li>
<li> c)       Repeated failure to deposit the proceeds of transactions on a daily basis.  </li>
<li> d)      Insolvency of the other party or if the audited financial results of the business of the other(that) party discloses that the total liabilities(whole liability) of the business of the other party exceed its all assets.  </li>
<li> e)       If a resolution is passed to wind-up the other party’s business or if a Receiver is appointed for any part of the other party’s property.  </li>
<li>  f)        Failure of the other party to obtain or maintain any license or the suspension or revocation of any license necessary for the conduct of the business of the other party pursuant to this Agreement.
</li>
</ul>
</p>
<p>
3.     Notwithstanding what is stated herein above, either party shall have the right to terminate this Agreement forthwith by giving notice in writing addressed to the other party at its last known address, in case of happening or occurrence of events including but not restricted to the following:
<ul class="list-unstyled">
<li> a)       Prosecution for any criminal offence of the Partner/s, Director/s, Sole Proprietor etc. of either party.  </li>
<li> b)      Breach of any of the terms or conditions of this agreement by either party and such breach are not cured within thirty days of notice by the affected party.  </li>
<li>  c)       False claims towards incentives, margins, refunds, credits, warranty claims, false financial information reports or any other data including but not limited to reporting requirements of either party. </li>
<li>d)      If the appointment or continuance of either of the party under this agreement is likely to result in, at the sole decision of the affected party, in loss of goodwill or reputation of the affected party.   </li>
<li>
e)       If any associate/franchisee of Franchisor commits any misconduct, fraud, cheating, misappropriation or any act lacking in good faith then Franchisor without issuing any notice may discard this agreement and compensation may be charged to the associate/franchisee. </li>
</ul>
</p>
<p>  4.     This agreement shall be terminated by Franchisor immediately without giving any notice to the Franchisee. In case Franchisor receives any objection from Supplier / Operator / Service Provider for such transactions through the outlets / customers of Retailer Franchisee/Digital Merchant Franchisee / down line Customers of the Franchisee or its subscriber directly through mobile/landline phones as well as internet and other modes. No Such written objection shall be provided to the franchisee.
</p>
<p> 5.     Franchisor shall be entitled to terminate the Appointment without notice:
<ul class="list-unstyled">
<li>
a)       if, by the acts or default of The Franchisee, Franchisor suffers damage to its name and(or) reputation;
</li>
<li>
b)      A change in control or management of The Franchisee
</li>
<li>
c)       Any event that would affect the ability of The Franchisee to perform its obligations.
</li>
<li>
d)      Any of the directors/partners/proprietor of The Franchisee are convicted of any criminal charge.
</li>
<li>
e)       The Franchisee is certified and declared to be of unsound mind.
</li>
<li>
f)        If any of the associate/franchisee uses name/logo/trademark of Franchisor without any prior written permission from Franchisor then he/she/company or outlet will be out of this agreement and will have to compensate to Franchisor or may face a legal action for such act.
</li>
</ul>
</p>
<p>  6.	The franchisor has  right to terminate the appointed Franchisee under this clause shall be without prejudice to any other right or remedy of Franchisor in respect of the breach concerned, if any, or any other breach.
</p>
<p>7.     Upon termination of appointment of The Franchisee as stated above:
<ul class="list-unstyled">
<li> a)      within Fifteen days from the date of termination, should clear all amounts due to Franchisor under these Terms and Conditions; </li>
<li> b)      Immediately return to Franchisor all confidential information provided to the Franchisee under this Agreement; </li>
<li> c)       Immediately return to Franchisor all material provided to the Franchisee under this Agreement; </li>
<li>d)      Immediately discontinue and cease to use the Franchisor’s intellectual property and shall immediately hand over any and all copies or documentation of such intellectual property, including POPs and other manuals, the terminal and software supplied by Franchisor, if any;  </li>
<li> e)      Immediately and permanently remove the software or cause it to be removed from all human and machine readable media (or other memory devices); </li>
<li> f)        Return all originals and/or copies of the confidential information, including the publicity and marketing materials in its possession; </li>
<li> g) Provide remote access to Franchisor to disable any software that Franchisor had installed; </li>
<li> h)  Remove all sign boards, banners, glow sign boards of Franchisor from its office and also all such material, which will indicate any association with Franchisor; </li>
<li> i) Cease to promote, market or advertise Franchisor or its products/services; and </li>
<li>j)  The Franchisee shall grant Franchisor, its employees or agents, access to its information technology systems for/up to a period of ninety working days after termination.</li>
</ul>
</p>
<p> 8.     Upon Franchisor serving a notice of termination, or upon expiry of the term, The Franchisee shall ensure that during the period of 6 month leading to the termination, all systems and procedures will be strictly adhered to and all customers are handled properly. All enquiries from customers will be diverted to Franchisor.
</p>
<p> 9.Notwithstanding the above, The Franchisee shall not, if so directed by Franchisor, discontinue the Services during the notice period and shall continue to provide the services as per these terms and conditions until indicated otherwise by Franchisor.
</p>
<p> 10.We reserve the right to restrict cash back/reward/award/royalty for any account with suspicious behavior or invalid details/credentials. Franchisor has the right to ask for documents to prove his/her identity
</p>
<p> 11.In the event of termination of these terms and conditions, the Parties shall settle all claims existing between them, after reconciliation of the accounts. Thereafter, the Franchisee shall have no right or claim or entitlement of any kind of compensation or any other payment and Franchisor shall not, under any circumstances, be liable or responsible, individually or collectively, fully or partly, for any kind of loss or expenses incurred by The Franchisee including any loss of profits, opportunity cost.
</p>
<p>  12.Upon termination of the appointment in accordance with Clause 12 above, the following Clauses shall survive: Clause 5 (Intellectual Property); Clause 7 (Exclusivity and Non Compete); Clause 6 (Confidentiality); Clause 11 (Indemnity); Clause 13 shall survive the termination of these Terms and Conditions: Clause 5 (Intellectual Property); Clause 6 (Confidentiality); Clause 7 (Exclusivity and Non Compete); Clause 11 (Indemnity); Clause 13 shall survive after the termination of these Terms and Conditions.
</p>
<br>
<b class="shead">[O]  <span class="underline"> WINDING – UP OF FRANCHISEE</span></b>

<br>
<p> In the event of voluntary or involuntary winding Up, liquidation or dissolution of the company /any Franchisee shall follow and liable for the below mentioned details.
</p>
<p> 1.      Franchisee shall take immediate steps to prompt their down line franchisee about the event in an orderly manner to reduce the loss and keep further cost to a minimum.
</p>
<p> 2.      Such Stock that is left unused in the franchisee's wallet shall be either refunded or shall provide sufficient time to the down line franchisees to utilize the balance maintained in the wallet.
</p>
<p> 3.      Franchisee shall clear all the dues and arrears before blocking the login access of all the down line franchisees and the same shall be communicated to the down line franchisees in advance. All down line franchisee must moved to Franchisor.
</p>
<p>
4.      Franchisee shall be of responsibility for any and all OTC taken from their down line franchisees for availing the services.
</p>
<p> 5.      Franchisee shall be of sole responsibility to clear any and all dues / arrears that may arise in the course of winding up of the business.
</p>
<p> 6.      Franchisee is of responsibility to strike off / delete the name from the domain with immediate effect after the completion of the winding up procedures.
</p>
<p> 7.      If Franchisee has downline/sub franchisee , then Franchisee is of responsibility to inform and to take proper consent from all the Down line franchisees before the completion procedure of the winding up so as to avoid complications.
</p>
<br>
<b class="shead">[P]  <span class="underline">WINDING – UP OF BUSINESS – FRANCHISOR</span></b>

<br>
<p>1.    In the event of Voluntary or Involuntary Winding Up, Liquidation, or Dissolution of FRANCHISOR, Franchisor shall take immediate steps to prompt franchisee about the said event in an orderly manner to reduce losses and keep further costs to a minimum and Franchisor shall owe the money maintained in the wallet by the Franchisee
</p>
<p>2.  The proportion / extent of balance stock / amount left in the wallet as unused even after regular transactions in the prescribed period of 4 months of winding up procedure shall be returned to Franchisee through predefined means and mutually agreed terms & conditions.*
</p>

<br>
<b class="shead">[Q]  <span class="underline">GENERAL TERMS AND CONDITIONS</span></b>

<br>
<p> 1.      As per the demand of the Franchisee, Franchisor buy stocks from different Suppliers / Operators / Service Provider / Authorized Distributors. Franchisor also makes sure that the same is available via software as Wallet for utilizing the demands.
</p>
<p> 2.      All stocks purchased by the Franchisee will be reflected in the wallet as Credited (Stock) and the customer shall dispense / allocate the stock to their Retailer Franchisee/Digital Merchant Franchisee / Franchisees at a rate that the customer may deem fit and fixed by Franchisor.
</p>
<p> 3.      Franchisor shall charge a One Time Non Refundable Fee (OTC) for Software / Core Application as per the mutually agreed rates.
</p>
<p> 4.      Franchisee is of discretion to sell the services or products bought by Franchisor at a price of their choice but only to that extend till the maximum price  fixed by the Franchisor/Service provider/Govt regulatory authority  .
</p>
<p> 5.      Franchisor shall be of no responsibility for any activities done by Franchisee/ Retailer Franchisee/Digital Merchant Franchisees / Franchisees to Franchisor’s Customers as Franchisor’s Customers can plug business with / enroll Unlimited, Retailer Franchisee/Digital Merchant Franchisees covered to their Brand Name.
</p>
<p>6.      The Franchisee shall be of responsibility to provide complete support to their down line Retailer Franchisee/Digital Merchant Franchisee/s / down line Customers for the efficient and effortless execution / functioning of business; in addition to that Franchisor shall not be held responsible for any disputes or fraudulent activities that may arise from the part of the Direct Customers of Franchisor.
</p>
<p> 7.      Franchisor and Franchisee mutually agrees that the software is tested thoroughly by a Team of Quality Analysts maintained by Franchisor and Customer has purchased the same after ensuring the accuracy and authenticity thence Franchisor shall not be of responsibility in the occurrence of any loss arising due to any misconfiguration, unwanted or unusual usage of the software by the customer.
</p>
<p> 8.      Franchisor shall provide / issue proper receipt for all the stocks purchased by the Franchisee and Franchisee is of responsibility to manage and remit the tax in connection with the business by their own.
</p>
<p> 9.      Franchisee shall maintain only one stock with Franchisor as and in its “Wallet” but Franchisor shall maintain separate stock for each Operator / Supplier / Service Providers for the convenience of business and effortless administration of business.
</p>
<p> 10.  Franchisee shall purchase stock by transferring the exact amount to the Bank Account of Franchisor and after receiving confirmation on the same from Franchisor's Bank, Franchisor shall credit an amount worth same to the Customer’s Wallet within 24 business hours.
</p>
<p> 11.  The Franchisee understands and agrees that Franchisor retains the right to transfer the technology in relation to the System to any party (the "Transferee") it so deems fit and upon such transfer, the obligations, rights and duties owed by the Franchisee towards Franchisor pursuant to this agreement shall stand transferred to the Transferee. For the avoidance of doubt, it is clarified that upon such transfer being effective, the relationship between the Franchisee and Franchisor shall stand terminated.
</p>
<p>12.  The Franchisee shall at all times maintain proper records as per the Franchisor guidelines and according to the law of India. The Franchisee hereby expressly agrees and undertakes to keep and maintain complete, up to date, and accurate and true records in connection with transactions undertaken and Franchisor shall have the right to have a practicing chartered accountant or any accountant or official of its choice to examine the records during office hours of the Franchisee's normal business hours for the purpose of determining the accuracy of the records herein referred to and its proper functioning in terms of RBI regulations/other authority  and guidelines provided for herein.
</p>
<p> 13.  Franchisors do not entertain any form of refund for any unused stocks and in a scenario where customer intends to wind up his business then he may have to consume the unused stock maintained in the wallet.
</p>
<p>  14.  Franchisee shall consume the entire stock in the wallet before the end of each financial year and if any stock is maintained as unused, then Franchisee may carry forward the stock to the next financial year upon a written request detailing the requirement but on or before the cut-off date.
</p>
<p> 15.  All transactions with respect to the request for purchasing of stocks shall be absolutely via bank in the mode of RTGs / NEFT / IMPS / Cheque and no other mode of transactions like Cash Deposits in the neighboring banks / cash deposit machine shall be acceptable, Even though Franchisor do not entertain cash deposit / CDM facility but certain exceptions are provided in case of emergency. In case of a cash deposit, the Franchisee/ User needs to seek prior approval from Franchisor and the prescribed mode for “Approval” shall be either in “Written format or via Email”. Please make the payment for wallet limit and Services only through non-cash transactions mode such as NACH / NEFT /RTGS / A/c Payee Bank draft/ A/c Payee Cheque /IMPS. Any penalty levied on {{$globalData->site_title}} under Section 271DA of Finance Act 2017/Other any Act on account of cash transaction/s will be recovered along with the legal cost from the respective depositor.
</p>
<p>
16. Franchise be aware that {{$globalData->site_title}} will never ask for your Email Id, OTP or
Portal Password. NEVER share such information with anyone, even if claiming
to represent the company.  </p>
<p> 17. Any discrepancy found like counterfeit currency or counterfeit money identified / detected / tracked, shall be the sole responsibility of the Franchisee and to tantamount, an equivalent amount shall debited / deducted from Franchisee account and no prior information on the same shall be intimated to the Franchisee.
</p>
<p> 18. Franchisee shall not compel its down line Retailer Franchisee/Digital Merchant Franchisee s/ DSO FRANCHISEE/ SUPER DSO FRANCHISEE for direct cash deposit in Franchisor’s bank account as Franchisor approves only those cash deposit those are pre-approved as per the written request or email received from the Franchisee.
</p>
<p> 19.  Usage of inbound or outbound voice communication (Tele / Electronic Communication) or to send or to receive SMS from and to the software shall be charged extra as per the mutually agreed terms between Franchisor and the Franchisee thence the customer shall purchase the same separately.
</p>
<p> 20.  Franchisee is of liberty to offer any mode of service delivery to its down line / customers that are acceptable and supported by Franchisor.
</p>
<p> 21.  This Franchisee agreement shall remain effective for a period of 1 year from the date of appointment after the expiry period Franchisee is required to apply for fresh renewal with the company. The company will be the sole decision maker to decide about termination of the same or continuation for a further period based upon the performance.
</p>
<p> 22.  Franchisee shall furnish veterans regarding sale, stock and inventories of the company's products with it and report to the company about the market conditions and consumer’s demands in relation to the products of the company.
</p>

<p>
23.  At the initial stage the Franchisee has to buy a product as per the investment scheme, afterwards the franchisee can avail the products in retail according to their requirements.
</p>
<p>24.  The Franchisee shall make the advance payment RTGS/ NEFT/ IMPS/ Payment Gateway/ Demand Draft / At Par Cheque favoring Franchisor, payable at Jaipur after deducting the necessary discount along with product orders. Company will send/deliver the products within 15 working days(delay in transition is not franchisor’s responsibility) after receipt of the order along with payment according to product category.
</p>
<p>25.  The Franchisee has to sell the product to their clients for the actual cost. It should not exceed the maximum price if franchisor found(receives) any complaints then the franchisor has rights to terminate franchisee without any prior notice. Only service charge can be taken by franchisee decided by franchisor/service provider via email/sms etc any type of media.
</p>
<p>26.  The Franchisee has to submit the copy of bills of sold products along with the complete client details to franchisor on demand.
</p>
<p>
27.  That in wallet of franchisor some extra services are being provided by Franchisor. Further if any legal issue occurs via Govt. organization then Cash back/ Reward/Award/Royalty etc can be stopped without notification. The franchisee has no issues on(in) it.
</p>
<p>28.  If a franchisee does not remain  active for 3 months he will not be considered as a franchisee. He/She may able to rejoin with a joining fee.(active franchisee means he/she does transactions for 1/3 days of each month )
</p>
<p> 29.  That the franchisee shall not copy, reproduce, modify, decompile or reverse engineer any software, hardware or firmware of Company in any manner whatsoever.</p>
<p> 30.  If any Franchisee joins also as an Franchisee/Retailer Franchisee/Digital Merchant Franchisee / DSO FRANCHISEE/ SUPER DSO FRANCHISEE using his/her another details as in fake(fraudulent) way then He/ She as well as Sub Franchisees joined under him/her will be terminated from immediate effect. Or may move under(in) franchisor’s downline.
</p>
<p>31.  That along with the above all Franchisees have to follow strict compliances of rules and he/she is also bound to not to reveal any idea or logic developed or generated in the premises of Franchisor.
</p>
<p> 32.  That Problem resolution will be only be through remote login or by telecommunication between office times/ings (9.30AM to 6.30PM) except national holidays and 4th Saturday, 30th January will be company's annual off due to Annual Function on 29th January. Company will be on leave from 9.30 AM (28th) to 12.00 AM (30th January).
</p>
<p> 33.  That franchisee shall be responsible for all telephone equipment and communication charges related to such support.
</p>
<p>
34.  That onsite service will not be available in any condition by franchisor.
</p>
<p>35.  Franchisee shall not pledge, hypothecate, sub-lease, sell or dispose off or otherwise transfer any rights or interest in the service to any other person in any manner.
</p>
<p> 36.  The above terms and conditions are based on the company's policy, procedures and other rules currently applicable in India and are subjected to amendments and adjustments from time to time. In all matters including those not specifically covered here such as online version of this software or new software’s developed in new technology time to time, etc you will be governed by the rules of the company as shall be in force from time to time.
</p>
<p>
37.  Your registered computer/laptop can be checked at any working time for authenticity whether you are using legal version (Authorized Registered franchisee/client) or not. Denial for the same will lead to termination of services.
</p>
<p>
38.  The Franchisor has reserve the right on first login page, home page or other pages whenever required for advertisement purpose only. The Franchisor also has rights for its name and logo in the footer of software's main screen.
</p>
<p>39.  If any suspicious activities or neglecting of  the terms & conditions found then Franchisor reserves right to suspension(suspend) of(the) services and termination of account/login at any time without prior notice and any explanation. Also, any reward/ award/ royalty/ cash back/ any other benefits will be withdrawn with penalty and legal action can be taken.
</p>
<p>
40.  If franchisee does not work satisfactorily and as per guidelines or no business generation for 3 consecutive months will lead to make the agreement null and void after a specific period
</p>
<p>41.  That Franchisor takes integrity issues seriously and will not hesitate to penalize a Franchisee if it’s found using fraudulent methods. Any of these(such) methods, if franchisee uses, could result in account suspension and followed by legal action.
</p>
<p> 42.  That when the security reason occurs, we can close(shut) down the software without any prior Information. Its not possible to give information to all clients. For latest and authentic information to call on our helpline numbers ({{$globalData->telephone}}). Or mail us info@primehubsofttechsolutions.com.
</p>
<p>
43.  Franchisor reserves rights for modification and discontinue(discontinuation) of any Scheme/ Plan/ Offer at any time without prior notice and any explanation.
</p>
<p>44.  Franchisor has the right to end or call back any or its entire offer without prior notice.
</p>
<p>45.  This agreement valid for 1 year only after that no renewal charges/may be charge and Franchisor reserve rights for this Franchisee continuation or not and you can transfer up or down and your upline/downline can be shifted.
</p>
<p>46.	Non-Disparagement and Publicity: - During the term of this agreement, franchisee will no disparage to franchisor or Franchisor’s trademarks, website, mobile apps, products or services, or services, or display any such items in a derogatory or negative manner on any web site or in any public forum or press release without the franchisor’s written approval and consent received by email every time from info@primehubsofttechsolutions.com </p>
<br>
<b class="shead">[R] <span class="underline">PRIVACY POLICY</span></b>

<br>
<p>1.     FRANCHISOR has the utmost respect for its Franchisee’s / Customer's Privacy. This Privacy Policy embodies our commitment to its protection through adherence to fair electronic information practices. Franchisee/ Customer may have FRANCHISOR's promise that FRANCHISOR shall not electronically process customer’s personal and/or business information in any way that is incompatible with this agreement.
</p>
<p>2.   With respect to security: Franchisor has got appropriate security measures in place available in Franchisor’s physical facilities to protect against the loss, misuse or alteration of information that Franchisor has processed from Franchisor’s end. If required in response to a subpoena, court order of verified administrative body requesting disclosure of a transaction, Franchisor may disclose the limited amount of Personally Identifiable Information as may be required in legal proceedings. Franchisor will limit the scope and will only disclose that information, which is required.  We also follow our complete privacy policy and Franchisee also have to follow privacy policy available on website www.primehubsofttechsolutions.com 
</p>
<p>3.	All the Data processed under the agreement between franchisee and franchisor is subject to the Data Privacy Regulations under applicable laws including but not limited to General Data Protection Regulation (GDPR) (EU) 2016/679 and all the Data Privacy Laws prevalent in India and as amended from time to time and any other applicable Laws restricting collection, use, disclosure, storage, processing and free movement of personal information.  In so far as information provided, or to be provided, by franchisee to franchisor includes the personal information of customers, franchisee represent and warrant that : franchisee have obtained sufficient informed prior consent in writing from each Customer to whom any personal information relates to, in order to franchisor to comply with applicable Data Privacy Regulations and which allows franchisor to collect, use, disclose, process, transfer and store such information for the purposes as agreed between franchisee and franchisor from time to time and as per the Privacy Policy of Franchisor, and franchisee will provide franchisor with such consent as and when requested by franchisor.</p>
<br>
<b class="shead">[S]  <span class="underline">TRADEMARKS</span></b>

<br>
<p>All trademarks, logos, and service marks identifying the products and services (collectively the "trademarks") displayed on this site, are registered and unregistered trademarks and are the property of their respective owner. Nothing contained on the site should be construed as granting, by implication, estoppels, or otherwise, any license or right to use any trademark displayed on the site without the written permission of Franchisor or such other party that may own the trademarks displayed on the Site. Misuse of the trademarks displayed on the site, or any other content on the site, except as provided in this section (Legal Information), is strictly prohibited. Franchisor will aggressively enforce its intellectual property rights to the fullest extent of the law, including the seeking of criminal prosecution. No logo, graphic, sound or image from this web site may be copied or retransmitted unless expressly permitted by Franchisor in writing. Please report any such instances of use to info@primehubsofttechsolutions.com. </p>
<br>
<b class="shead">[T]   <span class="underline">COPYRIGHT</span></b>

<br>
<P> All materials published or otherwise accessible through this site including, but not limited to, news articles, texts, forms, photographs, images, illustrations, audio clips, video clips, softwares, and other materials (the "Content") are protected by copyright, and are owned by Franchisor and any others( it’s vendors/service providers ) which may own copyright or which may be the party credited as the provider of the Content. All visitors shall abide by all additional copyright notices, information, and restrictions contained in the content accessed through our website.
</P>
<br>
<b class="shead">[U]  <span class="underline">MISCELLANEOUS</span></b>

<br>

<P> 1.     <b> Governing Law:</b>   This Agreement shall be governed by and construed in accordance with the laws of India, without regard to conflicts of law provisions and, subject to the arbitration provisions of the Franchisee.
</P>
<P>
2.    <b>Arbitration: </b>    Any controversy, dispute or claim arising out of or relating to this agreement or the breach hereof shall be endeavored to be settled by mutual discussions between the authorized representatives of both Parties within a period of one month from the date of notification of any such controversy, dispute or claim in writing by one Party to the other and failing which by sole arbitrators appointed by {{$globalData->site_title}} Soft Pvt ltd in accordance with the provisions of the Arbitration shall be conducted in the English language. The proceedings shall be governed as per the Arbitration and Conciliation Act, 1996. The venue for the arbitration proceedings shall be at Jaipur, Rajasthan. The award shall be binding on both parties and immediately enforceable in a court of law or equity. Each party shall bear its own costs for the arbitration and attorney’ fees unless declared otherwise by the arbitral award. This agreement is executed in Jaipur and only the Hon’ble High Court at Jaipur and all subordinate courts shall have the jurisdiction.
Notwithstanding the foregoing, the Parties acknowledge that this Agreement may be subject to review by the respective governments, authorities, statutory authorities, courts, tribunals, regulators of the countries of either Party or any third party. If any requirement under any law or any conditions imposed by any such aforementioned body alters the terms and conditions of this Agreement or is otherwise against the national interest of either Party, the affected Party may terminate this agreement forthwith and without liability.
</P>
<P> 3.    <b>Non-Exclusive Appointment: </b>    The Franchisee hereby acknowledges that all of the rights provided under these terms and conditions including area of operation, without limitation, the limited license to use Franchisor’s intellectual property are non-exclusive in nature and nothing herein shall be read to prejudice any right that Franchisor confer upon to any other person one any other right or permission to perform the activities contemplated under these Terms and Conditions.
</P>
<P> 4.   <b> Force Majeure: </b>
<b>  FORCE MAJEURE </b>
The term force majeure relates to the law of insurance and is frequently used in construction contracts to protect the parties in the event that a segment of the contract cannot be performed due to causes that are outside the control of the parties, such as natural disasters, that could not be evaded through the exercise of due care.
Franchisor or Franchisee as the case may be, shall be entitled to suspend or excuse performance of its respective obligations (except payment obligations) under this Agreement to the extent that such performance is impeded by an event of force majeure (‘Force Majeure’).
Force Majeure Events
A Force Majeure event means any event or circumstance or a combination of events and circumstances referred to in this clause, which:
<ul class="list-unstyled">
<li>    (a)            is beyond the reasonable control of the affected Party; </li>
<li>      (b)            such Party could not have prevented or reasonably overcome with the exercise of reasonable skill and care;  </li>
<li>
(c)            does not result from the negligence of such Party or the failure of such Party to perform its obligations under this Agreement;  </li>
<li>     (d)            is of an incapacitating nature and prevents or causes a delay or impediment in performance; and </li>
<li>  (e)            may be classified as all or any of the following events:
<p>Such events include:</p>
<ul class="list-unstyled">
<li>    (i)            act of God, including earthquake, flood, inundation, landslide, exceptionally adverse weather conditions, storm, tempest, hurricane, cyclone, lightning, thunder, volcanic eruption, fire or other extreme atmospheric conditions;</li>
<li>   (ii)            radioactive contamination or ionizing radiation or biological contamination except as may be attributable to the MSP’s use of radiation or radioactivity or biologically contaminating material;</li>
<li>    (iii)            industry wide strikes, lockouts, boycotts, labour disruptions or any other industrial disturbances as the case may be not arising on account of the acts or omissions of the Franchisor Web Portal/ Software and which affects the performance of the Franchisee under this Agreement; or </li>
<li>
(iv)            an act of war (whether declared or undeclared), hostilities, invasion, armed conflict or act of foreign enemy, blockade, embargo, prolonged riot, insurrection, terrorist or military action, civil commotion or politically motivated sabotage, for a continuous period exceeding seven (7) days </li>
</ul>
</li>
</ul>







If Franchisor is prevented from performing any of its obligations under this Agreement due to any cause beyond Franchisor's reasonable control, including, but without limitation to, any act of god, fire, flood, explosion, war, strike, embargo, government regulation, civil or military authority, acts or omissions of carriers, transmitters, providers, vandals, or hackers, major system break down and data loss beyond recoverable (a “Force Majeure Event”) the time for Franchisor's performance will be extended for the period of the delay or inability to perform due to such occurrence; provided, however that if Franchisor is unable to cure that event within 30 (thirty) days of the Force Majeure Event ceasing, or such further time as may be granted by Franchisor, Franchisor may terminate The Franchisee's appointment without any compensation or damages.
</P>
<P> 5.    <b> Injunctive Relief: </b>  Franchisor shall be entitled to injunctive relief in the event of breach of the terms of these Terms and Conditions by The Franchisee. To prevent or curtail any actual or threatened breach by The Franchisee of the express provisions of these terms and conditions or purpose fundamental (though not expressed) to signing of these Terms and Conditions.
</P>
<P> 6.   <b> Relationship:</b>  The Services rendered by the Franchisee under this agreement shall be provided to Franchisor on “Principle to Principle” basis and shall not create any employee-employer relationship between both. Franchisee shall provide all services hereunder as an independent entity, and nothing in this agreement creates or shall be deemed to create the relationship of partners, any association, partnership, a joint venture, employer-employee, or principal-agent or master and servant, or employer and employee  between both. The Franchisee shall not, without Franchisor’s prior written approval, either on its invoices, letterheads or any other place or by any other means, orally or in writing, make any statement or representation, calculated or liable to induce others to believe that The Franchisee is the agent of Franchisor or do any act, deed or things to bind Franchisor in any way in dealing with any third party (ies). The Franchisee is providing services to the customers and any dispute with the consumer shall be sole responsibility of The Franchisee.
</P>
<P>
7.  <b>Notices: </b>   Any notice required to be provided hereunder by one party to the other shall be given in writing and shall be delivered by (i) personal messenger, (ii) proof of delivery requested courier service or (iii) facsimile. All notices shall be delivered to the addresses of the parties as given in this agreement or such other addresses as shall have been notified to the other party for that purpose. (iv)Online system as email/other online media such as via phone, via whatsApp messaging.
</P>
<P>
8.   <b>  Assignment:</b>  The Franchisee may not assign or delegate any of its rights or obligations hereunder without a prior written consent from Franchisor. Subject to the foregoing, the rights and obligations under these terms and conditions shall ensure to the benefit of, and shall be binding upon, the heirs, legatees, successors, representatives, and permitted assigns of the respective Parties.
</P>
<P> 9.      For the purpose of this agreement, the term “Software” shall include custom built software that is owned by Franchisor, or software that has been licensed from third party suppliers by Franchisor and in relation to which Franchisor has obtained the right to sub license from such third party suppliers.
</P>
<P>
10.  The Franchisee shall not sublicense, assign or otherwise transfer the said Software to any person and/or any third party and is expressly prohibited from distributing, sublicensing, assigning, transferring or otherwise, the Software, or other technical documentation / information pertaining thereto, or any portions thereof in any form.
</P>
<P>
11.  The Franchisee shall not make any changes / modifications / alterations in entire / any part of Software / Intellectual Property of Franchisor.
</P>
<P> 12. <b>Severability: </b>   If for any reason whatsoever any provision of these terms and conditions is or becomes, or is declared to be, invalid, illegal or unenforceable under applicable law, then the Parties will negotiate in good faith to agree on one or more provisions to be substituted there for, which provisions shall, as nearly as practicable, leave the Parties in the same or nearly similar position to that which prevailed prior to such invalidity, illegality or unenforceability. Such invalidity, illegality or unenforceability shall not affect any other provisions of these terms and conditions, and these terms and conditions shall be construed as if such invalid, illegal or unenforceable provision had never been contained in these terms and conditions, and the remaining provisions of these terms and conditions shall be given full force and effect.
</P>
<P>
13.  <b>Change of Terms: </b>  Franchisor shall at their sole discretion alters, modify or amend these terms and conditions from time to time and the same shall be updated and displayed by Franchisor on their Websites. Franchisor may modify, terminate and/or suspend services anytime with or without prior notice, due to any changes in internal policies, rules, regulations and laws set by relevant authorities and or regulators.
</P>
<P>
14. <b> Waiver:</b>  A waiver by Franchisor in respect of a breach of a provision of these terms and conditions by the Franchisee will not be deemed to be a waiver in respect of any other breach and the failure of Franchisor to enforce at any time a provision of these terms and conditions will in no way be interpreted as a waiver of such provision.
</P>
<P>
15.  <b>Language: </b>  This Agreement has been made and signed in the English language. All documents, specifications, handbooks and correspondence shall be made in the English language.
</P>
<P>
16.   <b>Third Parties: </b> Nothing in these terms and conditions, unless expressly provided for herein, is intended to confer upon any person, other than the Parties hereto and their permitted successors and assigns, any rights or remedies under or by reason of these Terms and Conditions.
</P>
<P>
17.  <b> Further Actions:</b>  The Parties shall do or cause to be done such further acts, deeds, matters and things and execute such further documents and papers as may be reasonably required to give effect to the terms of these Terms and Conditions.
</P>
<P>
18. <b> Costs:</b>   The Franchisee shall bear all taxes, fees, levies and other expenses in relation to its appointment pursuant to these Terms and Conditions.
</P>
<P>
19. <b>Rights Cumulative:</b>  The rights, powers, privileges and remedies provided in these terms and conditions are cumulative and are not exclusive of any rights, powers, privileges or remedies provided by applicable law or otherwise. No failure to exercise nor any delay in exercising any right, power, privilege or remedy under these terms and conditions shall in any way impair or affect the exercise thereof or operate as a waiver thereof in whole or in part. Similarly, no single or partial exercise of any right, power, privilege or remedy under these terms and conditions shall prevent any further or other exercise thereof or the exercise of any other right, power, privilege or remedy.
</P>
<p>
20.	<b>Non Solicitation and Non Compete:</b> Franchisee During the term of this agreement and for a period of 24 (twenty four) months thereafter immediately following the expire or termination of this agreement for any reason whether with or without cause, either:
</p>
<ul class="list-unstyled">
    <li>i)	Directly or indirectly , solicit , induce ,recruit or encourage any employees of the franchisor to leave their employment , or join any other employment or undertake any activity that is of similar nature so as to give any sort of competition to the business of franchisor </li>
    <li>ii)	Take away any clients/customer or other franchisee of franchisor or attempt to solicit , induce , recruit , encourage or take away clients/customer or other franchisee of franchisor , either for itself or for any other person or entity </li>
    <li>iii)	Join the services or be associated with any former employee of franchisor who is undertaking or seeks to undertake any activity competing with business of franchisor </li>
</ul>
<p>21.	KYC Compliance:</p>
<ul class="list-unstyled">
    <li>“KYC” stands for Know Your Customer/franchisee and refers to the various norms, rules, laws and statutes issued by Reserve Bank of India/Other regulatory authorities  from time to time.</li>
    <li>Franchisor is required to procure personal identification details from franchisee before any Services can be delivered and at the time of Registration and/ or on a later date, for availing and / or continuation of services.</li>
    <li>The collection, verification, audit and maintenance of correct and updated Customer/franchisee information is a continuous process and franchisor reserves the right, at any time, to take steps necessary to ensure compliance with all relevant and applicable KYC requirements</li>
    <li>We reserve the right to discontinue Services/ reject applications for franchisor’s services at anytime if there are discrepancies in information and/or documentation provided by franchisee.</li>
    <li>Any information provided to Franchisor with the intention of securing franchisor  shall vest with franchisor, and may be used, for any purpose consistent with any applicable law or regulation, at its discretion.</li>
    <li>If the particulars provided by franchisee in the KYC documents do not match with the details mentioned in the KYC enrolment form, then franchisor has the right to forfeit the balance amount in your franchisee’s wallet.</li>
    <li>Subject to guidelines/notifications issued by RBI/ Other regulatory authorities from time to time these limitations may be reviewed and modified at the discretion of franchisor without prior intimation you. </li>
</ul>
<p><b>22.	YOUR OBLIGATION TOWARDS PAYMENT SYSTEM PROVIDERS AND CARD ASSOCIATIONS: </b>As you will be using the services of Payment System Providers and Card Associations to process your payment instructions, franchisee consents and agrees to comply with the rules, guidelines, directions, instructions, requests, etc. (“Guidelines”) made by the Payment System Providers and Card Associations from time to time. Notwithstanding our assistance in understanding the Payment System Providers and Card Association Guidelines, franchisee expressly acknowledges and agrees that franchisee is assuming the risk of compliance with all applicable Guidelines. Franchisee further acknowledges that the Payment System Providers, Card Associations and his issuing bank may also put limitations and restrictions on him, at its sole discretion. Franchisee is responsible for keeping itself up -to- date and compliant with all such Guidelines. In addition, the Payment System Providers and Card Associations have the right to reject payments made by franchisee and its customer  for any reason whatsoever. If he and his customer fails to comply with their obligations towards the Payment System Providers, we may suspend or terminate franchisee Account. </p>
<p><b>23.	REJECTION OF AUTHENTICATION AND AUTHORIZATION</b>Franchisee understands that the Payment System Providers and/or Card Association and/or your issuing bank may reject authentication and/or authorization of transaction placed by him and his customer  for any reason including but not limited to insufficient funds, incorrect authentication details provided, expired card/bank account, risk management, suspicion of fraudulent, illegal or doubtful transactions, selling of banned items, use of compromised cards or bank account numbers, use of banned/blacklisted cards or bank account numbers, use of suspicious API or in accordance with the RBI, Acquiring Banks, Issuing Institution and/or Card Association rules, guidelines, regulations, etc. and any other laws, rules, regulations, guidelines in force in India. Franchisee further acknowledges that as a security measure Franchisor and/or the Payment System Providers may at our sole discretion, permanently or temporarily, block any card number, account numbers, group of cards or transactions from any specific blocked or blacklisted cards /, accounts, specific, group of IP addresses, devices, geographic locations and / or any such risk mitigation measures it wishes to undertake. As a risk management tool, Franchisor and/or the Payment System Providers reserve the right to limit or restrict transaction size, amount and/or monthly volume at any time. Franchisor will consider a variety of factors in making a decision and such determination will be at our sole discretion.</p>
<p><b>24.	RISK MONITORING; UNUSUAL OR SUSPICIOUS TRANSACTIONS</b>In an effort to manage it’s risk, Franchisor may monitor franchisee’s and it’s customer’s transactions and processing activity for high-risk practices or for fraudulent transactions. Franchisor may also engage third-party service providers to assist in these efforts and other elements of the Service. If franchisor believes there is suspicious or unusual activity,  franchisor may temporarily or permanently suspend franchisee’s access to the Service. Suspicious or unusual activity includes, but is not limited to changes in his  average transaction amount or processing pattern or use of different payment accounts.</p>
<p><b>25.	Franchisor shall not be liable for any loss</b>, expenses or damage whatsoever caused by:    a. Charge-backs from Acquirer Bank’s side. b. Failure for whatever reason of a card or any Device or a part thereof or the system to function properly or at all in relation to the Services agreed; or c. Unauthorized acquisition of information by any person through electronic or other interception of communication on Franchisee’s network/outlet. Franchisee agrees that franchisor will not be responsible for any bounce/ back charges.</p>
<p><b>26.	Franchisor’s relationship with Digital Merchant Franchisee</b>We provide online payment facilitation services. Through the Digital Merchant aggregate QR Code, we facilitate you in making payments to our registered Digital merchants (“Merchants”) for purchase of goods and services or to our registered Digital Merchant for paying  bill using debit card, credit card, net banking and any other acceptable modes of payment mechanism provided . These transactions are between the customer and you. We are only acting as an intermediary. We facilitate the collection of payments from customer and facilitate the settlement of such payments to the respective Merchant. We are not involved in the clearing or payment of the transaction. </p>
<p><b>27.	</b>In order to serve in this role, we have entered into agreements with third parties/payment processing system providers, to enable use of QR code developed by/for them in order for them to effect payments between you and customer and provide clearing, payment and settlement services with respect to transaction. It is to be clarified that the payment instructions are authenticated, authorized and processed by the Card Associations and customer’s issuing bank through the Digital Merchant QR Code and we do not have any role in the same. </p>
<p><b>28.	Linking to Other Sites:</b>Our developed websites/www.besmartcitizen.com/www.primehubsofttechsolutions.com/ www.primehubsofttechsolutions.com or Be Smart Citizen Application links to other websites that may collect personally identifiable information about you. Franchisor is not responsible for the privacy practices or the content of those linked websites. </p>
<br>
<b class="shead">[V]    <span class="underline">DISCLAIMERS:-</span></b>

<br>
<p>1. <b>Use of Services: -  </b>      Copying or reproduction of the services, or any part thereof, to any other server or location for commercial use or for further reproduction or redistribution is expressly prohibited. Permission to use any of the content of these services may be obtained by sending a request to info@primehubsofttechsolutions.com Violators will be prosecuted to the maximum extent possible.
</p>
<p>2.  <b>    Links to Third Party/service Sites: - </b>    The linked sites referred to in this web site may not be under the control of Franchisor Services. Franchisor Services are not responsible for the contents of any linked site or any link contained in a linked site, or any changes or updates to such sites. Franchisor services provide these links as a convenience to visitors only. The inclusion of any link does not imply endorsement by Franchisor Services of the linked site.
</p>
<p>3. <b>   Legal Disclaimer :- </b>      In no event shall Franchisor services be liable for any special, indirect or consequential damages or any damages whatsoever resulting from use of these services, whether in an action of contract, negligence or other tortuous action.
</p>
<p> 4.  <b>  Technical Issues: - </b>      Neither Franchisor Services nor Franchisor shall be liable for damages of any kind related to your use of or inability to access these services. Given that technology and online experiences are unpredictable, franchisor do not guarantee that the function or operation of these services will be uninterrupted or error-free, that defects will be corrected, or that these services or the server that makes it available will be free of viruses or other harmful elements. As a visitor to and user of these Services, franchisee must assume full responsibility for any costs associated with connection to and use of the services, and you agree that your access is undertaken at your own risk.
</p>
<p>
5.   <b>  Service Issues: -  </b>    Franchisor Services and franchisee’s attempt to present the most recent and accurate information on these Services at all times. However, there may be occasions when some of the information on the www.primehubsofttechsolutions.com www.primehubsofttechsolutions.com or Franchisor group’s other sites may contain typographical errors or inaccuracies. Any errors are accidental and we apologize for this incorrect information. We reserve the right to amend errors at any time without prior notice.
</p>
<p>
6.   <b> Service Changes: - </b>      We reserve the right to make changes to charge of Services without prior notice.
</p>
<p>7. <b>  Submissions: - </b>       While franchisor will make every effort to respond quickly to franchisee email messages, facebook , whatsapp franchisor are under no obligation to respond to all pieces of correspondence received through these services, or to maintain franchisee submitted comments in confidence, or to pay compensation of any kind for franchisee comments or submissions. While franchisor welcome franchisee comments and feedback regarding these products and the services of {{$globalData->site_title}} and all of franchisee comments, feedback, ideas, suggestions, and other submissions that are disclosed or submitted through www.primehubsofttechsolutions.com shall become and remain the property of Franchisor. Any such disclosure or submission by franchisee is a declaration of the full release of all proprietary claims and/or intellectual rights regarding franchisee submission.
</p>
<br>
<b class="shead">[W]    <span class="underline">COMMUNICATION DISCLAIMER</span></b>

<br>
<p>The Franchisee hereby understands and agrees that being a Franchisor Franchisee/Retailer Franchisee/Digital Merchant Franchisee /DSO FRANCHISEE/SUPER DSO FRANCHISEE, Franchisor may communicate include communications but not limited to voice, SMS, digital, video, and/or any other mode of innovative communication method, as deemed fit and proper by the Company and that these communications are considered as part and parcel of the Services. The Franchisee shall not be able to opt out of receiving these messages and/or communication in any way whatsoever and The Franchisee hereby agrees to receive any communication from the Company. The Franchisee also understands that the communication may include and contain advertisements. Franchisee also bound by franchisor communication policy at  <a href="#">www.primehubsofttechsolutions.com</a>
</p>
<br>
<b class="shead"> [X]   <span class="underline"> DECLARATION </span></b>

<br>
<p> 1.     I/We hereby apply to become a Retailer Franchisee/Digital Merchant Franchisee /DSO FRANCHISEE/SUPER DSO FRANCHISEE of {{$globalData->site_title}} for facilitating/ distributing/ providing/ marketing of different product/ services/ schemes/ activities (“Services”) facilitated/ provided/ introduced/ distributed/ made available by Franchisor. If appointed as   Retailer Franchisee/Digital Merchant Franchisee / DSO FRANCHISEE/ SUPER DSO FRANCHISEE. </p>
<p> 2.     I/We agree and confirm to abide by the rules and regulations of Franchisor that may be in force from time to time.
</p>
<p> 3.     I/We hereby confirm that I am/we are engaged in sales/marketing of products/services in my/our organization and I am/we are competent and capable of the work assigned to me/us by Franchisor.
</p>
<p> 4.      I/We declare that the above information is true, correct and fair to the best of my/our knowledge and belief, and I/We further undertake to submit all necessary document/s, paper/s, proof/s, information and agreement as required by Franchisor now or from time to time.
</p>
<p> 5.     I/We further declare that I/We have read all terms and conditions attached with this form for appointment as Retailer Franchisee/Digital Merchant Franchisee /DSO FRANCHISEE/SUPER DSO FRANCHISEE/MDSO Franchisee  and I am/We are ready to act as per such terms and conditions and all other terms and conditions informed to me/us by Franchisor from time to time. I/We shall be liable/responsible for any breach of any terms/conditions mentioned by Franchisor. I/We shall be solely, exclusively and absolutely liable/ responsible for my/our any act/omission which shall be harmful (cost/consequence) to Franchisor/its Affiliates. I/We also authorize Franchisor to withhold any brokerage / commission / fees / charges / deposit due to me / us, if any, till submission of the said documentation, papers, information, proofs and agreement to the satisfaction of Franchisor.
</p>
<p>
6.     I/we certify that all the information given above and in the proceeding pages by me/us is/are complete and correct. </p>
<p>
7.     I/We declare that I/We am/ are authorized to sign on behalf of my organization and that my directors and shareholders/member (Where relevant) are in total agreement of my / our franchising.
</p>
<p>8.     I/We understand that the approval of my/ our Organization as franchisee shall be done as per the norms of the Franchisor.
</p>
<p>
9.     I/ we understand that Franchisor reserves the right to terminate the franchisee without assigning any reason.
</p>
<p>
10.I/we understand that the franchisee is approved for ONE year only, subject to subsequent renewal.
</p>
<p> 11.That I/We have received a copy of the tariff guide/product guide and have read and understood the contents thereof and agree to abide by the same, subjected to changes from time to time.
</p>
<p> 12.I/We further unconditionally and irrevocably authorize Franchisor, to debit my/our account from time to time with an amount equivalent to the fees and charges for the issue and use to the wallet/money transfer Services as decided by Franchisor from time to time.
</p>
<p>
13.I/We agree and shall understand that no transaction could be reversed by Franchisor once executed.
</p>
<p> 14. I/We hereby authorize Franchisor to seek and/or verify particulars including KYC provided by me either by itself or from independent sources.
</p>
<p> 15.I/we declare that the franchisee will abide by all rules and directions of Franchisor given time to time.
</p>
<p>16.I/we hereby also declare that I have also been apprised that these terms and conditions are also available on the website of the Franchisor  www.primehubsofttechsolutions.com ” which has been duly perused by me on the website of the franchisor.
</p>
<p> 17.I/We also undertake that and any change in the terms and conditions governing my/our appointment may not be notified by Franchisor to me/us but shall be binding on me/us if the change in the terms and conditions are made online by Franchisor. </p>
<p> 18.I/We undertake to keep myself/ourselves updated in respect of change in the Terms and Conditions and other all policies  initiated/made by Franchisor in its Website-“www.primehubsofttechsolutions.com”.
</p>
<p>19.I/We undertake to immediately inform the Company of all my cash deposits and transfer of funds into the designated Bank Accounts of the Company and shall get the limit from the Company thereafter. I/We will ensure me that the working limit in the portal by the Company against the cash deposit/fund transfer is made available to me immediately and this will remain as my/our basic responsibility. I /we have noted that the Company will not be held responsible for not assigning of any working limit against my cash deposits/fund transfer if I fail to inform the Company immediately after the deposits and do not get my working limit within two hours of cash deposit/fund transfers made by me/us. I/We have understood very well that in case of any negligence on my/our part in this regard, may lead to the working limit to someone else by mistake knowingly or unknowingly, for which the Company will not be held responsible under any circumstances. I/we will ensure at my/our own that the proper communication is received at the Company and any failure in this regard would be my/our own responsibility and Company will not be held responsible for that. I/we shall always remain abide by all the terms and conditions as specified above and as may be changed from time to time by the Company in respect of use of the portal and in respect of all services.
</p>
<p>
20.I/we shall inform immediately in case any excess amount is received in my portal by any means including by the Franchisee. I/we expressly authorize to the Company for withdrawing any excess amount given by mistake by the Company or by the Franchisee. I/we expressly accept the right of the Company to adjust any amount which I/we may owe to the Company at any point of time and even for the accrual of all kinds of liabilities which may fall upon me/us due to any kind of claim of the Company.
</p>
<p> 21.I/we shall remain always vigil in respect of my/our statement of transactions and balances in the statement and shall report any discrepancy therein to the Company immediately and not later than 24 hours from the time of discrepancy. I/we shall not hold Company responsible on account of any lapse on my/our part in this regards.
</p>
<p>22. I/we shall be responsible for payment of all kinds of the taxes including the GST/TDS in respect of any charges realized from the customers/Retailer Franchisee/Digital Merchant Franchisee /Franchisees/end users on all our services.
</p>
<p>23.I/we undertake to always display the rate list of the applicable charges on domestic remittance/other all services like pan card, aeps and shall not overcharge the customers under any circumstances.
</p>
<p>24.I have read and fully understood and hereby confirm to undertake, accept and abide by the contents of these Terms and Conditions.
</p>
<p> 25.	I shall abide by the code of conduct as specified in the Company in letter and spirit.I/We hereby apply to become an authorized Franchisee of Franchisor and provide all the Franchisor Services that I am authorized to offer in my capacity as a Franchisee of your partner bank or in the capacity of a Merchant Franchisee to accept payments through Franchisor Wallet, debit/credit/prepaid Cards, and Third party Prepaid Instruments.
</p>
<p>
26.	If I/we found guilty for immoral practices or unethical behavior with {{$globalData->site_title}}’s employee(s) will be terminated straight away followed with legal actions.
</p>
<p>27.	I/we agree that the minimum joining age of {{$globalData->site_title}} franchisee is 18 years on the date of execution of this agreement and /or on the date of commencement of services from franchisor </p>
<p>
28.	I/we agree and bound by the All General T&C  available on www.primehubsofttechsolutions.com
</p>
<p>29.	I/We agree to follow the Guidelines issued by Reserve Bank of India/Regulatory authorities from time to time in relation to Digital Payment Transactions.
</p>

<br>
<b class="shead"> [Y]  <span class="underline">  AGREEMENT TO FRANCHISORS’S TERMS AND CONDITIONS </span></b>

<br>
<p>
By signing up/using to Franchisor’s Services and using Franchisor’s Products, Franchisee intents to be legally bound and also agree to the terms within the agreement and intending to be legally bound, the parties have executed this Agreement to make it effective from the date and year first written above/ from the date of use of any one service/ from the date of Joining of franchisee is on which he was after many discussions joined/Registered with franchisor </p>
<b> Franchisee’s computer/mobile phone or other such devices’ required credentials i.e. IP, Log etc are kept with {{$globalData->site_title}}’s data base as a witness of this conveyance. 
</b>
<p><b>This document is an electronic record in terms of Information Technology Act, 2000 and generated by a computer system and does not require any physical or digital signatures. This document is published in accordance with the provisions of Rule 3 of the Information Technology (Intermediaries guidelines) Rules, 2011 that provide for the due diligence to be exercised by the Website.</b></p>
</article>
                                        </div>
                                    </div>
                                </div>
                                <p>
                                    &nbsp;</p>
                                <br />
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</form>
</body>
</html>
