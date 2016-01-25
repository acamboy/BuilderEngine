<!-- You can replace this text with whatever you wish to display to your customers following an unsuccessful transaction-->
<br/><br/>
There was an error processing your subscription.  
To try again please <a href="<?php echo home_url()?>"><b><u>click here</u></b></a><br><BR>
Please contact our customer care department at <a href="mailto:custcare@yourdomain.com"><b><u>custcare@yourdomain.com</u></b></a>
or if you would prefer to subscribe by phone, call on 01 2839428349
NOTE: This link should bring the customer back to a place where an new orderid is
created so that they can try to use another card. It is important that a new orderid
is created because if the same orderid is sent in a second time Realex Payments will
reject it as a duplicate order even if the first transaction was declined.